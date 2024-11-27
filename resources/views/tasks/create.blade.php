@extends('layouts.app')

@section('content')
    <h1>Создать новую задачу</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="project_id" class="form-label">Проект</label>
            <select class="form-select select2" id="projects" name="projects[]" multiple>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ is_array(old('projects')) && in_array($project->id, old('projects')) ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="status_id" class="form-label">Статус</label>
            <select class="form-select select2" id="status_id" name="status_id">
                <option value="" selected disabled>Выберите статус</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Исполнитель</label>
            <select class="form-select select2" id="user_id" name="user_id">
                <option value="" selected disabled>Выберите исполнителя</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="condition_id" class="form-label">Состояние</label>
            <select class="form-select select2" id="condition_id" name="condition_id">
                <option value="" selected disabled>Выберите состояние</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection
