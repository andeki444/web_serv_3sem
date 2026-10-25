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

        @can('update', $article)
            <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
                <a href="{{ route('articles.edit', $article->id) }}" style="color: #d39e00; margin-right: 15px;">Редактировать эту статью</a>
            </div>
        @endcan
    </article>

    {{-- Секция комментариев --}}
    <section style="max-width: 800px; margin: 30px auto;">
        <h3>Комментарии</h3>

        {{-- 4. Сообщение о том, что комментарий ожидает модерации --}}
        @if(session('comment_status'))
            <div style="background-color: #fff3cd; color: #856404; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #ffeeba;">
                {{ session('comment_status') }}
            </div>
        @endif

        {{-- 5. Отображение только комментариев, прошедших модерацию --}}
        @php
            $approvedComments = $article->comments->where('is_approved', true);
        @endphp

        @forelse($approvedComments as $comment)
            <div style="background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; padding: 15px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <strong>{{ $comment->user->name ?? 'Аноним' }}</strong>
                    <span style="font-size: 12px; color: #888;">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <p style="margin: 0; color: #333; line-height: 1.5;">{{ $comment->content }}</p>
            </div>
        @empty
            <p style="color: #777;">Пока нет опубликованных комментариев. Будьте первым!</p>
        @endforelse

        {{-- Форма добавления комментария --}}
        <div style="margin-top: 30px; background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 6px;">
            <h4>Оставить комментарий</h4>

            @auth
                <form action="{{ route('comments.store', $article->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <textarea name="content" rows="4" required placeholder="Напишите ваш комментарий..." 
                                  style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-family: sans-serif;">{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 18px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        Отправить на модерацию
                    </button>
                </form>
            @else
                <p style="color: #666; margin: 0;">
                    Чтобы оставить комментарий, пожалуйста, <a href="{{ route('login') }}" style="color: #007bff;">войдите</a> или <a href="{{ route('register') }}" style="color: #007bff;">зарегистрируйтесь</a>.
                </p>
            @endauth
        </div>
    </section>
@endsection