<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class AuthController extends Controller
{
    // 1. Форма регистрации
    public function create()
    {
        return view('auth.register');
    }

    // 1. Сохранение нового пользователя в БД + redirect на форму авторизации
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $readerRole = Role::firstOrCreate(['name' => 'reader']);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $readerRole->id,
        ]);

        return redirect()->route('login')->with('success', 'Регистрация прошла успешно! Войдите в свой аккаунт.');
    }

    // 2. Форма авторизации (входа)
    public function loginForm()
    {
        return view('auth.login');
    }

    // 2. Аутентификация с присвоением токена Sanctum + redirect на главную
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Создание и присвоение персонального токена Sanctum
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return redirect()->route('home')->with('success', 'Вы успешно авторизовались!');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }

    // 3. Выход: удаление токенов, аннулирование сессии, обновление CSRF + redirect на главную
    // 3. Выход: удаление токенов, аннулирование сессии, обновление CSRF + redirect на главную
    public function logout(Request $request)
    {
        // 1. Удаление персональных токенов пользователя Sanctum
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // 2. Выход из веб-сессии через guard 'web'
        Auth::guard('web')->logout();

        // 3. Аннулирование текущей сессии
        $request->session()->invalidate();

        // 4. Обновление токена CSRF
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Вы успешно вышли из системы.');
    }
}