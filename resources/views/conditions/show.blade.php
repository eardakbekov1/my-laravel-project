@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $condition->name }}</h1>
        <p>{{ $condition->description }}</p>
        <a href="{{ route('conditions.index') }}" class="btn btn-secondary">Назад к списку</a>
    </div>
@endsection
