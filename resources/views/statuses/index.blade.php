@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список статусов</h1>
        <a href="{{ route('statuses.create') }}" class="btn btn-primary mb-3">Создать статус</a>

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
                <th>Состояние</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($statuses as $status)
                <tr>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->description }}</td>
                    <td>{{ $status->condition->name ?? 'Нет состояния' }}</td>
                    <td>
                        <a href="{{ route('statuses.edit', $status->id) }}" class="btn btn-warning">Редактировать</a>
                        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" style="display: inline;">
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
