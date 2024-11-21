@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать ID-Карту</h1>
        <form action="{{ route('id_cards.update', $idCard->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="role_id">Роль</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Выберите роль</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $role->id == $idCard->role_id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">Пользователь</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="">Выберите пользователя</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $idCard->user_id ? 'selected' : '' }}>
                            {{ $user->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="condition_id">Состояние</label>
                <select class="form-control" id="condition_id" name="condition_id">
                    <option value="">Выберите состояние</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ $condition->id == $idCard->condition_id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
