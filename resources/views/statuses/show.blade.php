@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $status->name }}</h1>
        <p>{{ $status->description }}</p>
        <p>Condition ID: {{ $status->condition_id }}</p>
        <a href="{{ route('statuses.index') }}" class="btn btn-secondary">Назад к списку</a>
    </div>
@endsection
