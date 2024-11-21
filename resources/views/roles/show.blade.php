{{-- resources/views/roles/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $role->name }}</h1>

        <p><strong>Описание:</strong> {{ $role->description ?? 'Нет описания' }}</p>

        <p><strong>Статус:</strong> {{ $role->condition ? $role->condition->status : 'Не указан' }}</p>

        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Редактировать</a>

        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>

        <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Назад к списку</a>
    </div>
@endsection
