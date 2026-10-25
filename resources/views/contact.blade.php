@extends('layout')

@section('title', 'Контакты')

@section('content')
    <h1>Контактная информация</h1>

    <ul>
        @foreach($contacts as $key => $value)
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
@endsection