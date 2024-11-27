@extends('layouts.app')

@section('content')
    <h1>Редактировать задачу: {{ $task->name }}</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $task->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status_id" class="form-label">Статус</label>
            <select class="form-select" id="status_id" name="status_id">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Исполнитель</label>
            <select class="form-select" id="user_id" name="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->first_name }} {{ $user->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="condition_id" class="form-label">Состояние</label>
            <select class="form-select" id="condition_id" name="condition_id">
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id', $task->condition_id) == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="projects" class="form-label">Проекты</label>
            <select class="form-select select2" id="projects" name="projects[]" multiple>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}"
                        {{ in_array($project->id, old('projects', $task->projects->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Обновить</button>
    </form>
@endsection
