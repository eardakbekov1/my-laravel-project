@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список состояний</h1>
        <a href="{{ route('conditions.create') }}" class="btn btn-primary mb-3">Создать состояние</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($conditions as $condition)
                <tr>
                    <td>{{ $condition->name }}</td>
                    <td>{{ $condition->description }}</td>
                    <td>
                        <a href="{{ route('conditions.edit', $condition->id) }}" class="btn btn-warning">Редактировать</a>
                        <form action="{{ route('conditions.destroy', $condition->id) }}" method="POST" style="display: inline;">
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
