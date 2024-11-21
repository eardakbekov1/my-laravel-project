@extends('layouts.app')

@section('content')
    <h1>Список пользователей</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Создать нового пользователя</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Состояние</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->condition->name ?? 'Не задано' }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
