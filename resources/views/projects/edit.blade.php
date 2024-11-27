{{-- resources/views/projects/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование проекта: {{ $project->name }}</h1>

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Название проекта -->
            <div class="mb-3">
                <label for="name" class="form-label">Название проекта</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required>
            </div>

            <!-- Описание проекта -->
            <div class="mb-3">
                <label for="description" class="form-label">Описание проекта</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $project->description) }}</textarea>
            </div>

            <!-- Статус -->
            <div class="mb-3">
                <label for="status_id" class="form-label">Статус</label>
                <select class="form-select" id="status_id" name="status_id">
                    <option value="">Выберите статус</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id', $project->status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Условие -->
            <div class="mb-3">
                <label for="condition_id" class="form-label">Состояние</label>
                <select class="form-select" id="condition_id" name="condition_id">
                    <option value="">Выберите состояние</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ old('condition_id', $project->condition_id) == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Выбор задач -->
            <div class="mb-3">
                <label for="tasks" class="form-label">Задачи</label>
                <select class="form-select select2" id="tasks" name="tasks[]" multiple>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}"
                            {{ in_array($task->id, old('tasks', $project->tasks->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $task->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>

    </div>
@endsection
