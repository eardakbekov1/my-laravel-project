@extends('layouts.app')

@section('content')
    <h1>Просмотр задачи: {{ $task->name }}</h1>

    <ul>
        <li><strong>Название:</strong> {{ $task->name }}</li>
        <li><strong>Описание:</strong> {{ $task->description }}</li>
        <li><strong>Статус:</strong> {{ $task->status->name ?? 'Не задан' }}</li>
        <li><strong>Исполнитель:</strong> {{ $task->user->name ?? 'Не назначен' }}</li>
        <li><strong>Состояние:</strong> {{ $task->condition->name ?? 'Не задано' }}</li>
        <li><strong>Дата создания:</strong> {{ $task->created_at }}</li>
        <li><strong>Дата обновления:</strong> {{ $task->updated_at }}</li>
    </ul>

    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Редактировать</a>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Назад</a>
@endsection
