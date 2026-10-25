@extends('layout')

@section('title', 'Создание статьи')

@section('content')
    <p><a href="{{ route('articles.index') }}">&larr; Назад к списку</a></p>
    <h2>Создание новой статьи</h2>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Дата публикации:</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Заголовок:</label>
            <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Краткое описание:</label>
            <textarea name="short_desc" rows="3" required style="width: 100%; padding: 8px; box-sizing: border-box;">{{ old('short_desc') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Полный текст:</label>
            <textarea name="desc" rows="6" required style="width: 100%; padding: 8px; box-sizing: border-box;">{{ old('desc') }}</textarea>
        </div>

        <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px;">
            Сохранить статью
        </button>
    </form>
@endsection