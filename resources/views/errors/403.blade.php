@extends('layout')

@section('title', 'Ошибка доступа')

@section('content')
    <div style="max-width: 550px; margin: 40px auto; padding: 25px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 6px; text-align: center;">
        <h2 style="color: #856404; margin-top: 0;">403 | Ограничение доступа</h2>
        <p style="font-size: 16px; color: #856404; margin-bottom: 20px;">
            {{ $exception->getMessage() ?: 'У вас недостаточно прав для выполнения этого действия.' }}
        </p>
        <a href="/" style="color: #007bff; text-decoration: underline;">&larr; Вернуться на главную</a>
    </div>
@endsection