@extends('layout')

@section('title', 'Модерация комментариев')

@section('content')
    <h1 style="margin-bottom: 20px;">Модерация комментариев</h1>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: #fff;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Автор</th>
                <th>Статья</th>
                <th>Комментарий</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td><strong>{{ $comment->user->name ?? 'Аноним' }}</strong></td>
                    <td>
                        <a href="{{ route('articles.show', $comment->article_id) }}" target="_blank" style="color: #007bff; text-decoration: none;">
                            {{ $comment->article->name ?? 'Статья удалена' }}
                        </a>
                    </td>
                    <td style="max-width: 300px; word-break: break-word;">{{ $comment->content }}</td>
                    <td style="white-space: nowrap; font-size: 13px; color: #666;">{{ $comment->created_at->format('d.m.Y H:i') }}</td>
                    <td style="white-space: nowrap; text-align: center;">
                        {{-- Принять --}}
                        <form action="{{ route('comments.approve', $comment->id) }}" method="POST" style="display: inline-block; margin-right: 8px;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                                Принять
                            </button>
                        </form>

                        {{-- Отклонить --}}
                        <form action="{{ route('comments.reject', $comment->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Отклонить и удалить этот комментарий?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                                Отклонить
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #777;">
                        Новых комментариев, ожидающих модерации, нет.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection