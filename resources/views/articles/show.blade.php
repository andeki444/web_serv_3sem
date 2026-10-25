@extends('layout')

@section('title', $article->name)

@section('content')
    <p><a href="{{ route('articles.index') }}">&larr; Назад ко всем статьям</a></p>

    <article style="max-width: 800px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #ddd;">
        <h1 style="margin-top: 0;">{{ $article->name }}</h1>
        <p style="color: #777; font-size: 14px;">Дата публикации: {{ $article->date }}</p>

        @if($article->full_image)
            <div style="text-align: center; margin: 20px 0;">
                <img src="{{ asset($article->full_image) }}" alt="{{ $article->name }}" style="max-width: 100%; border-radius: 6px;">
            </div>
        @endif

        <div style="line-height: 1.7; font-size: 16px;">
            <p><strong>{{ $article->short_desc }}</strong></p>
            <p>{{ $article->desc }}</p>
        </div>

        <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
            <a href="{{ route('articles.edit', $article->id) }}" style="color: #d39e00; margin-right: 15px;">Редактировать эту статью</a>
        </div>
    </article>
@endsection