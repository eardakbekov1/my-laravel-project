@extends('layouts.app')

@section('content')
    <h1>Просмотр пользователя: {{ $user->first_name }} {{ $user->last_name }}</h1>

    <ul>
        <li><strong>Имя:</strong> {{ $user->first_name }}</li>
        <li><strong>Фамилия:</strong> {{ $user->last_name }}</li>
        <li><strong>Имя пользователя:</strong> {{ $user->username }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Состояние:</strong> {{ $user->condition->name ?? 'Не задано' }}</li>
        <li><strong>Дата создания:</strong> {{ $user->created_at }}</li>
        <li><strong>Дата обновления:</strong> {{ $user->updated_at }}</li>
    </ul>

    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Редактировать</a>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Назад</a>
@endsection
