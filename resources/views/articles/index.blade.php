@extends('layout')

@section('title', 'Новости из БД')

@section('content')
    <h1>Список новостей (из базы данных)</h1>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Дата</th>
                <th>Превью</th>
                <th>Название</th>
                <th>Краткое описание</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->date }}</td>
                    <td style="text-align: center;">
                        <img src="{{ asset($article->preview_image) }}" width="100">
                    </td>
                    <td><strong>{{ $article->name }}</strong></td>
                    <td>{{ $article->short_desc }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Статей нет</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection