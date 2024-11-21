@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование состояния</h1>

        <form action="{{ route('conditions.update', $condition->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Название состояния</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $condition->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Описание состояния</label>
                <textarea class="form-control" id="description" name="description">{{ $condition->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
