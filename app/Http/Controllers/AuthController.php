<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // метод для отображения формы регистрации
    public function create()
    {
        return view('auth.signin');
    }

    // метод для валидации и вывода результата в JSON
    public function registration(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        return response()->json([
            'message' => 'Регистрация прошла успешно',
            'data' => $validatedData
        ]);
    }
}