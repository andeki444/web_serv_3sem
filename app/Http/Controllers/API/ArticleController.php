<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\VeryLongJob;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    // Список статей (с кэшированием пагинации)
    public function index(Request $request)
    {
        $page = $request->get('page', 1);

        $articles = Cache::remember("articles_page_{$page}", 3600, function () {
            return Article::latest('id')->paginate(5);
        });

        return response()->json([
            'articles' => $articles
        ]);
    }

    // Просмотр одной статьи (с кэшированием и комментариями)
    public function show(Article $article)
    {
        $cachedArticle = Cache::rememberForever("article_show_{$article->id}", function () use ($article) {
            return $article->load(['comments.user']);
        });

        return response()->json([
            'article' => $cachedArticle
        ]);
    }

    // Создание новой статьи
    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);

        $validated = $request->validate([
            'date' => 'required|date',
            'name' => 'required|min:3|max:255',
            'short_desc' => 'required|min:5',
            'desc' => 'required|min:10',
        ]);

        $validated['preview_image'] = 'preview.jpg';
        $validated['full_image'] = 'full.jpeg';

        $article = Article::create($validated);

        // Очистка кэша страниц
        $totalPages = ceil(Article::count() / 5);
        for ($i = 1; $i <= $totalPages + 1; $i++) {
            Cache::forget("articles_page_{$i}");
        }

        // Очередь почты
        VeryLongJob::dispatch($article);

        // Уведомление читателям
        $readers = User::where('id', '!=', Auth::id())
            ->whereHas('role', function ($query) {
                $query->where('name', 'reader');
            })
            ->get();

        Notification::send($readers, new NewArticleNotification($article));

        return response()->json([
            'message' => 'Статья успешно добавлена!',
            'article' => $article
        ], 201);
    }

    // Редактирование статьи
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $validated = $request->validate([
            'date' => 'required|date',
            'name' => 'required|min:3|max:255',
            'short_desc' => 'required|min:5',
            'desc' => 'required|min:10',
        ]);

        $article->update($validated);

        Cache::flush();

        return response()->json([
            'message' => 'Статья успешно обновлена!',
            'article' => $article
        ]);
    }

    // Удаление статьи
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        Cache::flush();

        return response()->json([
            'message' => 'Статья успешно удалена!'
        ]);
    }
}