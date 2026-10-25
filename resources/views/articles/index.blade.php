@extends('layout')

@section('title', 'Управление статьями')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Статьи из базы данных</h1>
        <a href="{{ route('articles.create') }}" 
           style="background-color: #28a745; color: white; padding: 10px 16px; text-decoration: none; border-radius: 4px; font-weight: bold;">
            + Создать статью
        </a>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Дата</th>
                <th>Превью</th>
                <th>Заголовок</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td style="white-space: nowrap;">{{ $article->date }}</td>
                    <td style="text-align: center;">
                        <img src="{{ asset($article->preview_image ?? 'preview.jpg') }}" alt="" width="80" style="border-radius: 4px;">
                    </td>
                    <td>
                        <a href="{{ route('articles.show', $article->id) }}" style="font-weight: bold; color: #007bff; text-decoration: none;">
                            {{ $article->name }}
                        </a>
                        <p style="font-size: 13px; color: #666; margin: 4px 0 0 0;">{{ $article->short_desc }}</p>
                    </td>
                    <td style="white-space: nowrap; text-align: center;">
                        <a href="{{ route('articles.edit', $article->id) }}" style="color: #d39e00; margin-right: 12px;">Редактировать</a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Точно удалить статью?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; text-decoration: underline;">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Статей пока нет</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $articles->links() }}
    </div>
@endsection