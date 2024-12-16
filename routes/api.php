<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ConditionController;
use App\Http\Controllers\API\IdCardController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\StatusController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('conditions', ConditionController::class)->names([
    'index' => 'conditions.list',
    'store' => 'conditions.insert',
    'show' => 'conditions.view',
    'update' => 'conditions.modify',
    'destroy' => 'conditions.delete',
]);

Route::apiResource('id-cards', IdCardController::class)->names([
    'index' => 'id-cards.list',
    'store' => 'id-cards.insert',
    'show' => 'id-cards.view',
    'update' => 'id-cards.modify',
    'destroy' => 'id-cards.delete',
]);

Route::apiResource('projects', ProjectController::class)->names([
    'index' => 'projects.list',
    'store' => 'projects.insert',
    'show' => 'projects.view',
    'update' => 'projects.modify',
    'destroy' => 'projects.delete',
]);

Route::apiResource('roles', RoleController::class)->names([
    'index' => 'roles.list',
    'store' => 'roles.insert',
    'show' => 'roles.view',
    'update' => 'roles.modify',
    'destroy' => 'roles.delete',
]);

Route::apiResource('statuses', StatusController::class)->names([
    'index' => 'statuses.list',
    'store' => 'statuses.insert',
    'show' => 'statuses.view',
    'update' => 'statuses.modify',
    'destroy' => 'statuses.delete',
]);

Route::apiResource('tasks', TaskController::class)->names([
    'index' => 'tasks.list',
    'store' => 'tasks.insert',
    'show' => 'tasks.view',
    'update' => 'tasks.modify',
    'destroy' => 'tasks.delete',
]);

Route::apiResource('users', UserController::class)->names([
    'index' => 'users.list',
    'store' => 'users.insert',
    'show' => 'users.view',
    'update' => 'users.modify',
    'destroy' => 'users.delete',
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
