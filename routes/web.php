<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

// главная страница теперь вызывает метод index контроллера
Route::get('/', [MainController::class, 'index']);

// маршрут галереи с параметром имени изображения
Route::get('/galery/{img}', [MainController::class, 'galery'])->name('galery');

// маршруты из первой лабы
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