@extends('layouts.app')

@section('content')
    <h1>Список задач</h1>

    <!-- Кнопка создания задачи -->
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Создать задачу
    </a>

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
            <th>Проект</th>
            <th>Исполнитель</th>
            <th>Описание</th>
            <th>Статус</th>
            <th>Состояние</th>
            <th style="width: 180px;">Действия</th> <!-- Увеличиваем ширину столбца -->
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->name }}</td>
                <td>
                    @if ($task->projects->isNotEmpty())
                        @foreach($task->projects as $project)
                            <span class="badge bg-secondary">{{ $project->name }}</span>
                        @endforeach
                    @else
                        <span>Не привязан</span>
                    @endif
                </td>
                <td>{{ $task->user->first_name ?? 'Не назначен' }} {{ $task->user->last_name ?? '' }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->status->name ?? 'Не задан' }}</td>
                <td>{{ $task->condition->name ?? 'Не задано' }}</td>
                <td>
                    <!-- Иконки для действий -->
                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info" title="Просмотр">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning" title="Редактировать">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту задачу?')" title="Удалить">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
