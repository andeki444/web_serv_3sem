<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Регистрация политики для статей
        Gate::policy(Article::class, ArticlePolicy::class);

        // 2. Хук шлюза: проверяется прежде остальных проверок
        // Если пользователь модератор — ему сразу разрешены любые действия
        Gate::before(function (User $user, string $ability) {
            if ($user->role && $user->role->name === 'moderator') {
                return true;
            }
        });
    }
}