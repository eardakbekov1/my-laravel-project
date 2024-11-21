@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование статуса</h1>

        <form action="{{ route('statuses.update', $status->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Название статуса</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $status->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Описание статуса</label>
                <textarea class="form-control" id="description" name="description">{{ $status->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="condition_id">Состояние</label>
                <select class="form-control" id="condition_id" name="condition_id">
                    <option value="" {{ is_null($status->condition_id) ? 'selected' : '' }}>Не выбрано</option>
                    @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}"
                            {{ $status->condition_id == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
