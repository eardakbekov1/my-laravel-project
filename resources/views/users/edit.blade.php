@extends('layouts.app')

@section('content')
    <h1>Редактировать пользователя: {{ $user->first_name }} {{ $user->last_name }}</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="first_name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Фамилия</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Имя пользователя</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="condition_id" class="form-label">Состояние</label>
            <select class="form-select" id="condition_id" name="condition_id">
                <option value="">Не выбрано</option>
                <!-- Здесь будут перечислены возможные условия из базы данных -->
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Обновить</button>
    </form>
@endsection
