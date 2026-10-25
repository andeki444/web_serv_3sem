<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    // Просмотр списка статей доступен всем
    public function viewAny(?User $user): bool
    {
        return true;
    }

    // Просмотр отдельной статьи доступен всем
    public function view(?User $user, Article $article): bool
    {
        return true;
    }

    // Создание статьи
    public function create(User $user): Response
    {
        return $user->role && $user->role->name === 'moderator'
            ? Response::allow()
            : Response::deny('Только модератор имеет право создавать статьи.');
    }

    // Редактирование статьи
    public function update(User $user, Article $article): Response
    {
        return $user->role && $user->role->name === 'moderator'
            ? Response::allow()
            : Response::deny('Только модератор имеет право редактировать эту статью.');
    }

    // Удаление статьи
    public function delete(User $user, Article $article): Response
    {
        return $user->role && $user->role->name === 'moderator'
            ? Response::allow()
            : Response::deny('Только модератор имеет право удалять статьи.');
    }
}