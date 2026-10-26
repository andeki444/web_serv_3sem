<?php

namespace App\Http\Middleware;

use App\Models\ArticleView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogArticleView
{
    public function handle(Request $request, Closure $next): Response
    {
        // Сохраняем URL запроса в базу данных
        ArticleView::create([
            'url' => $request->fullUrl(),
        ]);

        return $next($request);
    }
}