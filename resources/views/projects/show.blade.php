{{-- resources/views/projects/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $project->name }}</h1>

        <p><strong>Описание:</strong> {{ $project->description ?? 'Нет описания' }}</p>

        <p><strong>Статус:</strong> {{ $project->status ? $project->status->status : 'Не указан' }}</p>

        <p><strong>Условие:</strong> {{ $project->condition ? $project->condition->status : 'Не указано' }}</p>

        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Редактировать</a>

        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>

        <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Назад к списку</a>
    </div>
@endsection
