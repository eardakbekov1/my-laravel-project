{{-- resources/views/roles/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список ролей</h1>

        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Создать роль</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Состояние</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description ?? 'Нет описания' }}</td>
                    <td>{{ $role->condition ? $role->condition->name : 'Не указан' }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Редактировать</a>

                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
