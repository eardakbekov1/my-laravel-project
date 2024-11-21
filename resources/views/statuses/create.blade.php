@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создание статуса</h1>

        <form action="{{ route('statuses.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Название статуса</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Описание статуса</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="condition_id">Состояние</label>
                <select class="form-control" id="condition_id" name="condition_id">
                    <option value="" selected>Выберите состояние</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection
