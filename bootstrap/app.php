<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->redirectGuestsTo('/login');

        // Регистрируем наш middleware для логирования просмотров
        $middleware->alias([
            'log.view' => \App\Http\Middleware\LogArticleView::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();