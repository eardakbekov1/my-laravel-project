@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h3>Задачи</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление задачами проекта.</p>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary w-100">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-success">
                    <div class="card-header bg-success text-white">
                        <h3>Проекты</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление проектами.</p>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-success w-100">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h3>Статусы</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление статусами.</p>
                        <a href="{{ route('statuses.index') }}" class="btn btn-outline-warning w-100">Перейти</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-info">
                    <div class="card-header bg-info text-white">
                        <h3>Состояния</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление состояниями.</p>
                        <a href="{{ route('conditions.index') }}" class="btn btn-outline-info w-100">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h3>Пользователи</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление пользователями.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger w-100">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h3>Роли</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление ролями.</p>
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary w-100">Перейти</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-light text-dark">
                        <h3>Карточки</h3>
                    </div>
                    <div class="card-body">
                        <p>Управление карточками.</p>
                        <a href="{{ route('id_cards.index') }}" class="btn btn-outline-light w-100">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
