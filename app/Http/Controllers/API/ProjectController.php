<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Получить список всех проектов.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return response()->json($projects);
    }

    /**
     * Создать новый проект.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'tasks' => 'nullable|array',
            'tasks.*' => 'exists:tasks,id',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status_id' => $validated['status_id'] ?? null,
            'condition_id' => $validated['condition_id'] ?? null,
        ]);

        if (!empty($validated['tasks'])) {
            $project->tasks()->sync($validated['tasks']);
        }

        return response()->json([
            'message' => 'Проект успешно создан!',
            'data' => $project->load('tasks'),
        ], 201);
    }

    /**
     * Получить данные о конкретном проекте.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Project $project)
    {
        $project->load(['tasks', 'status', 'condition']);
        return response()->json($project);
    }

    /**
     * Обновить проект.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'tasks' => 'nullable|array',
            'tasks.*' => 'exists:tasks,id',
        ]);

        $project->update($validated);

        if (!empty($validated['tasks'])) {
            $project->tasks()->sync($validated['tasks']);
        } else {
            $project->tasks()->detach();
        }

        return response()->json([
            'message' => 'Проект успешно обновлен!',
            'data' => $project->load('tasks'),
        ]);
    }

    /**
     * Удалить проект.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Проект успешно удален!',
        ]);
    }
}
