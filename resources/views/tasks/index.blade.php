<!-- resources/views/tasks/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Список задач</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Проект</th>
            <th>Исполнитель</th>
            <th>Статус</th>
            <th>Состояние</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->project->name ?? 'Не привязан' }}</td>
                <td>{{ $task->user->first_name ?? 'Не назначен' }} {{ $task->user->last_name ?? '' }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->status->name ?? 'Не задан' }}</td>
                <td>{{ $task->condition->name ?? 'Не задано' }}</td>
                <td>
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info">Просмотр</a>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Редактировать</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту задачу?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
