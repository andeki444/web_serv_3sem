<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

// Лаба 1 и 2
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

// Лаба 3 (Регистрация)
Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('registration');

// Лаба 5 (Полный CRUD и пагинация для статей)
Route::resource('articles', ArticleController::class);