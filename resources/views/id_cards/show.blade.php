@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ID-Карта: #{{ $idCard->id }}</h1>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Информация о карте</h5>
                <p><strong>Роль:</strong> {{ $idCard->role->name }}</p>
                <p><strong>Пользователь:</strong> {{ $idCard->user->username }}</p>
                <p><strong>Состояние:</strong> {{ $idCard->condition->name ?? 'Не указано' }}</p>
                <p><strong>Создано:</strong> {{ $idCard->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Обновлено:</strong> {{ $idCard->updated_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('id_cards.index') }}" class="btn btn-secondary mt-3">Вернуться к списку</a>
        <a href="{{ route('id_cards.edit', $idCard->id) }}" class="btn btn-warning mt-3">Редактировать</a>
        <form action="{{ route('id_cards.destroy', $idCard->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3">Удалить</button>
        </form>
    </div>
@endsection
