@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создание состояния</h1>

        <form action="{{ route('conditions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Название состояния</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Описание состояния</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection
