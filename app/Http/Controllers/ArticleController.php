<?php

namespace App\Http\Controllers;

use App\Mail\ArticleCreatedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Jobs\VeryLongJob;

class ArticleController extends Controller
{
    // 1. Список статей с пагинацией по 5 штук
    public function index()
    {
        $articles = Article::latest('id')->paginate(5);
        return view('articles.index', ['articles' => $articles]);
    }

    // 2. Страница с формой добавления
    public function create()
    {
        Gate::authorize('create', Article::class);
        return view('articles.create');
    }

    // 3. Сохранение новой статьи в БД с валидацией
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

        // 1. Создаем и сохраняем статью в БД
        $article = Article::create($validated);

        // 2. Отправляем задачу рассылки в очередь фоновых заданий
        VeryLongJob::dispatch($article);

        return redirect()->route('articles.index')
            ->with('success', 'Статья успешно сохранена, а уведомление модератору отправлено в очередь!');
    }

    // 4. Просмотр одной полной статьи
    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    // 5. Страница с формой редактирования
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);
        return view('articles.edit', ['article' => $article]);
    }

    // 6. Обновление статьи в БД с валидацией
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

        return redirect()->route('articles.index')->with('success', 'Статья успешно обновлена!');
    }

    // 7. Удаление статьи из БД
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Статья успешно удалена!');
    }
}