<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

// Публичные страницы (Лабы 1 и 2)
Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/galery/{id}', [MainController::class, 'galery'])->name('galery');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    $contacts = [
        'Адрес' => 'г. Москва, ул. Большая Семёновская, д. 38',
        'Телефон' => '+7 (495) 223-05-23',
        'Email' => 'info@mospolytech.ru',
        'Время работы' => 'Пн-Пт с 09:00 до 18:00'
    ];
    return view('contact', ['contacts' => $contacts]);
})->name('contact');

// Публичный просмотр списка статей
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Маршруты авторизации и регистрации (Лаба 6)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Защищенные маршруты: только для авторизованных пользователей
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Выход из системы
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Добавление комментария пользователем
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Панель модерации комментариев (только для модератора)
    Route::get('/moderation/comments', [CommentController::class, 'index'])->name('comments.moderation');
    Route::patch('/moderation/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/moderation/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');