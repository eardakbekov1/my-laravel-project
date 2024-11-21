<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Показать список всех проектов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with(['status', 'condition'])->get(); // Загрузка связанных статусов и условий
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
        $conditions = Condition::all();  // Получаем все состояния
        $statuses = Status::all();       // Получаем все статусы

        return view('projects.create', compact('conditions', 'statuses'));  // Передаем данные в представление
    }


    /**
     * Сохранить новый проект.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        // Создание проекта
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'condition_id' => $request->condition_id,
        ]);

        return redirect()->route('projects.index')->with('success', 'Проект создан успешно!');
    }

    /**
     * Показать форму для редактирования проекта.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $statuses = Status::all();
        $conditions = Condition::all();
        return view('projects.edit', compact('project', 'statuses', 'conditions'));
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
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'condition_id' => $request->condition_id,
        ]);

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
