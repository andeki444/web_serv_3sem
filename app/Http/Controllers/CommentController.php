<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    // Добавление комментария пользователем (ожидает модерации)
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|min:2|max:1000',
        ]);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'is_approved' => false, // ждет одобрения
        ]);

        return redirect()->route('articles.show', $article->id)
            ->with('comment_status', 'Ваш комментарий отправлен и ожидает подтверждения модератором.');
    }

    // 2. Список комментариев, которые НЕ прошли модерацию (только для модератора)
    public function index()
    {
        // Проверка: доступ только модератору
        if (!Auth::user() || !Auth::user()->role || Auth::user()->role->name !== 'moderator') {
            abort(403, 'Только модератор имеет доступ к этой странице.');
        }

        $comments = Comment::with(['article', 'user'])
            ->where('is_approved', false)
            ->latest()
            ->get();

        return view('comments.moderation', ['comments' => $comments]);
    }

    // Принять комментарий
    public function approve(Comment $comment)
    {
        if (!Auth::user() || !Auth::user()->role || Auth::user()->role->name !== 'moderator') {
            abort(403, 'Только модератор может подтверждать комментарии.');
        }

        $comment->update(['is_approved' => true]);

        return redirect()->route('comments.moderation')
            ->with('success', 'Комментарий успешно опубликован!');
    }

    // Отклонить (удалить) комментарий
    public function reject(Comment $comment)
    {
        if (!Auth::user() || !Auth::user()->role || Auth::user()->role->name !== 'moderator') {
            abort(403, 'Только модератор может отклонять комментарии.');
        }

        $comment->delete();

        return redirect()->route('comments.moderation')
            ->with('success', 'Комментарий отклонен и удален.');
    }
}