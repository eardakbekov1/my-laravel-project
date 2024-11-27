<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\IdCardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('tasks', TaskController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('projects', ProjectController::class);
Route::resource('conditions', ConditionController::class);
Route::resource('statuses', StatusController::class);
Route::resource('id_cards', IdCardController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);
