@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создать ID-Карту</h1>
        <form action="{{ route('id_cards.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="role_id">Роль</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">Выберите роль</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">Пользователь</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="">Выберите пользователя</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="condition_id">Состояние</label>
                <select class="form-control" id="condition_id" name="condition_id">
                    <option value="">Выберите состояние</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection
