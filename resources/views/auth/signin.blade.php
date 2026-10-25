@extends('layout')

@section('title', 'Регистрация')

@section('content')
    <div style="max-width: 450px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
        <h2 style="text-align: center; margin-top: 0;">Регистрация</h2>

        {{-- вывод ошибок валидации --}}
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/signin" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; margin-bottom: 5px;">Имя:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 5px;">Пароль:</label>
                <input type="password" id="password" name="password" required 
                       style="width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <button type="submit" 
                    style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Зарегистрироваться
            </button>
        </form>
    </div>
@endsection