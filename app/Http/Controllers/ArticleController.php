<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Jobs\VeryLongJob;
use App\Notifications\NewArticleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
// 3. Добавляем фасад Cache
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    // 4. В методе index кэшируем данные списка и пагинации (remember)
    public function index(Request $request)
    {
        $page = $request->get('page', 1);

        // Кэшируем каждую страницу пагинации на 60 минут (3600 сек)
        $articles = Cache::remember("articles_page_{$page}", 3600, function () {
            return Article::latest('id')->paginate(5);
        });

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        Gate::authorize('create', Article::class);
        return view('articles.create');
    }

    // 5. В методе store удаляем кэш пагинации (forget)
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

        // 5. Очищаем сохраненные страницы пагинации через forget
        $totalPages = ceil(Article::count() / 5);
        for ($i = 1; $i <= $totalPages + 1; $i++) {
            Cache::forget("articles_page_{$i}");
        }

        // Очередь отправки почты (лаба 10)
        VeryLongJob::dispatch($article);

        // Рассылка уведомлений читателям (лаба 12)
        $readers = User::where('id', '!=', Auth::id())
            ->whereHas('role', function ($query) {
                $query->where('name', 'reader');
            })
            ->get();

        Notification::send($readers, new NewArticleNotification($article));

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно добавлена!');
    }

    // 6. В методе show кэшируем просмотр статьи вместе с комментариями навсегда (rememberForever)
    public function show(Article $article)
    {
        $cachedArticle = Cache::rememberForever("article_show_{$article->id}", function () use ($article) {
            // Загружаем статью вместе со связанными комментариями и их авторами
            return $article->load(['comments.user']);
        });

        return view('articles.show', ['article' => $cachedArticle]);
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', $article);
        return view('articles.edit', ['article' => $article]);
    }

    // 7. В методе update очищаем весь кэш (flush)
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

        // Полная очистка кэша
        Cache::flush();

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно обновлена, кэш очищен!');
    }

    // 7. В методе destroy очищаем весь кэш (flush)
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        // Полная очистка кэша
        Cache::flush();

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно удалена, кэш очищен!');
    }
}