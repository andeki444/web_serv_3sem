@extends('layout')

@section('title', $article['Название'])

@section('content')
    <p><a href="/">&larr; Вернуться к списку статей</a></p>

    <article style="max-width: 800px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
        <h1 style="margin-top: 0;">{{ $article['Название'] }}</h1>
        <p style="color: #777; font-size: 14px;">Дата публикации: {{ $article['Дата'] }}</p>

        <div style="text-align: center; margin: 25px 0;">
            <img src="{{ asset($article['full_image']) }}" alt="{{ $article['Название'] }}" 
                 style="max-width: 100%; height: auto; border-radius: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
        </div>

        <div style="line-height: 1.7; font-size: 16px; color: #333;">
            <p>{{ $article['Описание'] }}</p>
        </div>
    </article>
@endsection