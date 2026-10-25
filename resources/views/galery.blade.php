@extends('layout')

@section('title', 'Просмотр изображения')

@section('content')
    <p><a href="/">&larr; Вернуться к списку статей</a></p>

    <div style="text-align: center; margin-top: 20px;">
        <img src="{{ asset($image) }}" alt="Полноразмерное изображение" style="max-width: 100%; height: auto; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    </div>
@endsection