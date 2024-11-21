{{-- resources/views/roles/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование роли: {{ $role->name }}</h1>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Название роли</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание роли</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $role->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="condition_id">Состояние</label>
                <select name="condition_id" id="condition_id" class="form-control">
                    <option value="">Выберите состояние</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ old('condition_id', $role->condition_id) == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Обновить роль</button>
        </form>
    </div>
@endsection
