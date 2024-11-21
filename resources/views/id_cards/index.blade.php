@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ID-Карты</h1>
        <a href="{{ route('id_cards.create') }}" class="btn btn-primary">Создать ID-Карту</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Роль</th>
                <th>Пользователь</th>
                <th>Состояние</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($idCards as $idCard)
                <tr>
                    <td>{{ $idCard->id }}</td>
                    <td>{{ $idCard->role->name }}</td>
                    <td>{{ $idCard->user->username }}</td>
                    <td>{{ $idCard->condition->name ?? 'Не указано' }}</td>
                    <td>
                        <a href="{{ route('id_cards.show', $idCard->id) }}" class="btn btn-info btn-sm">Просмотр</a>
                        <a href="{{ route('id_cards.edit', $idCard->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('id_cards.destroy', $idCard->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
