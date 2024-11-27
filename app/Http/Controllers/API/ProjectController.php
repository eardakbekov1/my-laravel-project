<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Project API",
 *     version="1.0.0",
 *     description="API для работы с проектами"
 * )
 */
class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Получить список всех проектов",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="Список всех проектов успешно получен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return response()->json($projects);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Создать новый проект",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Проект успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные данные",
     *         @OA\JsonContent()
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Получить данные о конкретном проекте",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные проекта успешно получены",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Проект не найден",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(Project $project)
    {
        $project->load(['tasks', 'status', 'condition']);
        return response()->json($project);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Обновить проект",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Проект успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Удалить проект",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Проект успешно удален"
     *     )
     * )
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Проект успешно удален!',
        ]);
    }

    /**
     * @OA\Schema(
     *     schema="ProjectCreateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название проекта"),
     *     @OA\Property(property="description", type="string", description="Описание проекта"),
     *     @OA\Property(property="status_id", type="integer", description="ID статуса проекта"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния проекта"),
     *     @OA\Property(property="tasks", type="array", description="Список задач",
     *         @OA\Items(type="integer")
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="ProjectUpdateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название проекта"),
     *     @OA\Property(property="description", type="string", description="Описание проекта"),
     *     @OA\Property(property="status_id", type="integer", description="ID статуса проекта"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния проекта"),
     *     @OA\Property(property="tasks", type="array", description="Список задач",
     *         @OA\Items(type="integer")
     *     )
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Project",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="ID проекта"),
     *     @OA\Property(property="name", type="string", description="Название проекта"),
     *     @OA\Property(property="description", type="string", description="Описание проекта"),
     *     @OA\Property(property="status_id", type="integer", description="ID статуса проекта"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния проекта"),
     *     @OA\Property(property="tasks", type="array", description="Задачи проекта",
     *         @OA\Items(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Property(property="status", ref="#/components/schemas/Status"),
     *     @OA\Property(property="condition", ref="#/components/schemas/Condition")
     * )
     */
}
