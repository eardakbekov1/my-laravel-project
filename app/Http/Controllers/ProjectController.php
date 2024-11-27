<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;
use App\Models\Task;

class ProjectController extends Controller
{
    /**
     * Показать список всех проектов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Получаем все проекты с их связанными задачами
        $projects = Project::with('tasks')->get();

        // Передаем проекты в представление
        return view('projects.index', compact('projects'));
    }

    /**
     * Показать форму для создания нового проекта.
     *
     * @return \Illuminate\Http\Response
     */
// app/Http/Controllers/ProjectController.php

    public function create()
    {
        $statuses = Status::all(); // Если есть выбор статусов
        $conditions = Condition::all(); // Если есть выбор состояний
        $tasks = Task::all(); // Задачи для выбора

        return view('projects.create', compact('statuses', 'conditions', 'tasks'));
    }



    /**
     * Сохранить новый проект.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id', // Валидируем статус
            'condition_id' => 'nullable|exists:conditions,id', // Валидируем состояние
            'tasks' => 'nullable|array', // Поле для задач
            'tasks.*' => 'exists:tasks,id', // Каждое значение — ID существующей задачи
        ]);

        // Создаем проект
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id, // Добавляем статус
            'condition_id' => $request->condition_id, // Добавляем состояние
        ]);

        // Привязываем задачи к проекту
        if ($request->has('tasks')) {
            $project->tasks()->sync($request->tasks); // Привязывает переданные задачи
        }

        return redirect()->route('projects.index')->with('success', 'Проект успешно создан');
    }

    /**
     * Показать форму для редактирования проекта.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Получаем проект по ID
        $project = Project::findOrFail($id);

        // Получаем все задачи
        $tasks = Task::all();

        // Получаем статусы и условия
        $statuses = Status::all();
        $conditions = Condition::all();

        // Передаем данные в представление
        return view('projects.edit', compact('project', 'tasks', 'statuses', 'conditions'));
    }

    /**
     * Обновить проект.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Найти проект или вернуть 404
        $project = Project::findOrFail($id);

        // Валидировать данные
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'tasks' => 'nullable|array',
            'tasks.*' => 'exists:tasks,id',
        ]);

        // Обновить данные проекта
        $project->update($validated);

        // Синхронизировать связи с задачами
        $project->tasks()->sync($validated['tasks'] ?? []);

        // Перенаправить с сообщением об успехе
        return redirect()->route('projects.index')->with('success', 'Проект обновлен успешно!');
    }

    /**
     * Показать информацию о проекте.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with(['status', 'condition'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Удалить проект.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Проект удален успешно!');
    }
}
