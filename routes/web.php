<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

// роут для отображения страницы регистрации
Route::get('/signin', [AuthController::class, 'create'])->name('signin');

// роут для отправки данных формы методом POST
Route::post('/signin', [AuthController::class, 'registration'])->name('registration');

Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{id}', [MainController::class, 'galery'])->name('galery');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    $contacts = [
        'Адрес' => 'г. Москва, ул. Большая Семёновская, д. 38',
        'Телефон' => '+7 (495) 223-05-23',
        'Email' => 'info@mospolytech.ru',
        'Время работы' => 'Пн-Пт с 09:00 до 18:00'
    ];

    return view('contact', ['contacts' => $contacts]);
});