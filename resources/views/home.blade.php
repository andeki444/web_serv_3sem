@extends('layout')

@section('title', 'Главная — Новости')

@section('content')
    <h1>Список статей</h1>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Дата</th>
                <th>Превью</th>
                <th>Название</th>
                <th>Краткое описание</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td style="white-space: nowrap;">{{ $article['Дата'] }}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('galery', ['img' => $article['full_image']]) }}" title="Открыть оригинал">
                            <img src="{{ asset($article['preview_image']) }}" alt="{{ $article['Название'] }}" width="120" style="border-radius: 4px;">
                        </a>
                    </td>
                    <td><strong>{{ $article['Название'] }}</strong></td>
                    <td>{{ $article['Краткое описание'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Записи не найдены</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection