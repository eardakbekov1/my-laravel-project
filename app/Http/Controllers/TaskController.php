<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Events\TaskUpdated;
use App\Models\Project;
use App\Events\TaskCreated;

class TaskController extends Controller
{
    // Метод для отображения всех задач
    public function index()
    {
        $tasks = Task::with('condition')->get(); // загружаем связанные состояния
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $statuses = Status::all();
        $users = User::all();
        $conditions = Condition::all();
        $projects = Project::all();

        return view('tasks.create', compact('statuses', 'users', 'conditions', 'projects'));
    }

    // Метод для сохранения новой задачи
    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'user_id' => 'nullable|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'projects' => 'nullable|array', // Ожидается массив ID проектов
            'projects.*' => 'exists:projects,id', // Каждое значение должно быть ID существующего проекта
        ]);

        // Создаем задачу
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'condition_id' => $request->condition_id,
        ]);

        // Привязываем проекты к задаче
        if ($request->has('projects')) {
            $task->projects()->sync($request->projects); // Привязываем проекты
        }

        event(new \App\Events\TaskCreated($task));

        // Перенаправляем
        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $statuses = Status::all(); // Предполагается, что у тебя есть модель Status
        $users = User::all(); // Модель User
        $conditions = Condition::all(); // Модель Condition
        $projects = Project::all(); // Модель Project (добавляем проекты)

        return view('tasks.edit', compact('task', 'statuses', 'users', 'conditions', 'projects'));
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, $id)
    {
        // Найти задачу или вернуть 404
        $task = Task::findOrFail($id);

        // Валидировать данные
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'user_id' => 'nullable|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id', // Проверка, что каждый проект существует
        ]);

        // Обновить данные задачи
        $task->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status_id' => $validated['status_id'] ?? null,
            'user_id' => $validated['user_id'] ?? null,
            'condition_id' => $validated['condition_id'] ?? null,
        ]);

        // Синхронизировать связи с проектами
        $task->projects()->sync($validated['projects'] ?? []);

        // Перенаправить с сообщением об успехе
        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена!');
    }

}
