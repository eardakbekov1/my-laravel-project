{{-- resources/views/projects/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование проекта: {{ $project->name }}</h1>

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Название проекта</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $project->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание проекта</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="condition_id">Состояние</label>
                <select name="condition_id" id="condition_id" class="form-control">
                    <option value="">Выберите состояние</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}  <!-- Здесь выводится название состояния -->
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status_id">Статус</label>
                <select name="status_id" id="status_id" class="form-control">
                    <option value="">Выберите статус</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}  <!-- Здесь выводится название статуса -->
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Обновить проект</button>
        </form>
    </div>
@endsection
