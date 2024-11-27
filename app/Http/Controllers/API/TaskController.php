<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use App\Models\Condition;
use App\Models\Project;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Task API",
 *     version="1.0.0",
 *     description="API для работы с задачами"
 * )
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Получить список всех задач",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получен список задач",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $tasks = Task::with(['condition', 'status', 'user', 'projects'])->get();
        return response()->json($tasks);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Создать новую задачу",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Задача успешно создана",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
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
            'user_id' => 'nullable|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
        ]);

        $task = Task::create($validated);

        if ($request->has('projects')) {
            $task->projects()->sync($validated['projects']);
        }

        event(new \App\Events\TaskCreated($task));

        return response()->json([
            'message' => 'Задача успешно создана!',
            'data' => $task->load(['condition', 'status', 'user', 'projects']),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Получить информацию о задаче",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получена информация о задаче",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Задача не найдена",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show($id)
    {
        $task = Task::with(['condition', 'status', 'user', 'projects'])->findOrFail($id);
        return response()->json($task);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Обновить задачу",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Задача успешно обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'user_id' => 'nullable|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
        ]);

        $task->update($validated);

        $task->projects()->sync($validated['projects'] ?? []);

        return response()->json([
            'message' => 'Задача обновлена успешно!',
            'data' => $task->load(['condition', 'status', 'user', 'projects']),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Удалить задачу",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Задача успешно удалена"
     *     )
     * )
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Задача успешно удалена!',
        ]);
    }

    /**
     * @OA\Schema(
     *     schema="TaskCreateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название задачи"),
     *     @OA\Property(property="description", type="string", description="Описание задачи"),
     *     @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *     @OA\Property(property="user_id", type="integer", description="ID пользователя, ответственного за задачу"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *     @OA\Property(property="projects", type="array", items=@OA\Items(type="integer"), description="Список ID проектов")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="TaskUpdateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название задачи"),
     *     @OA\Property(property="description", type="string", description="Описание задачи"),
     *     @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *     @OA\Property(property="user_id", type="integer", description="ID пользователя, ответственного за задачу"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *     @OA\Property(property="projects", type="array", items=@OA\Items(type="integer"), description="Список ID проектов")
     * )
     */
}
