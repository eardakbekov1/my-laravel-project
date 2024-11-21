<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Events\TaskUpdated;
use App\Models\Project;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'user_id' => 'nullable|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'condition_id' => $request->condition_id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $statuses = Status::all();
        $users = User::all();
        $conditions = Condition::all();

        return view('tasks.edit', compact('task', 'statuses', 'users', 'conditions'));
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        // Отправить событие
        broadcast(new TaskUpdated($task));

        // Вернуть редирект на страницу со списком задач
        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена');
    }



    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена!');
    }

}
