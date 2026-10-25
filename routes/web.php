<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

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