@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список проектов</h1>

        <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Создать проект</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Статус</th>
                <th>Состояние</th>
                <th>Задачи</th> <!-- Новый столбец для задач -->
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description ?? 'Нет описания' }}</td>
                    <td>{{ $project->status ? $project->status->name : 'Не указан' }}</td>
                    <td>{{ $project->condition ? $project->condition->name : 'Не указан' }}</td>

                    <!-- Новый столбец для задач -->
                    <td>
                        @foreach ($project->tasks as $task)
                            <span class="badge bg-secondary">{{ $task->name }}</span><br>
                        @endforeach
                    </td>

                    <td>
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info">Просмотр</a> <!-- Кнопка для просмотра -->
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Редактировать</a>

                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
