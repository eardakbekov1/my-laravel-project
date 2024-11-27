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
 *     title="Task Manager API",
 *     version="1.0.0",
 *     description="API для работы с Task manager"
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
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID задачи"),
     *                 @OA\Property(property="name", type="string", description="Название задачи"),
     *                 @OA\Property(property="description", type="string", description="Описание задачи"),
     *                 @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *                 @OA\Property(property="user_id", type="integer", description="ID пользователя, назначенного на задачу"),
     *                 @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания задачи"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления задачи")
     *             )
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
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Название задачи"),
     *             @OA\Property(property="description", type="string", description="Описание задачи"),
     *             @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя, назначенного на задачу"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *             @OA\Property(property="projects", type="array", @OA\Items(type="integer"), description="Список ID проектов")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Задача успешно создана",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID задачи"),
     *             @OA\Property(property="name", type="string", description="Название задачи"),
     *             @OA\Property(property="description", type="string", description="Описание задачи"),
     *             @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя, назначенного на задачу"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания задачи"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления задачи")
     *         )
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
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID задачи"),
     *             @OA\Property(property="name", type="string", description="Название задачи"),
     *             @OA\Property(property="description", type="string", description="Описание задачи"),
     *             @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя, назначенного на задачу"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания задачи"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления задачи")
     *         )
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
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Название задачи"),
     *             @OA\Property(property="description", type="string", description="Описание задачи"),
     *             @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя, назначенного на задачу"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *             @OA\Property(property="projects", type="array", @OA\Items(type="integer"), description="Список ID проектов")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Задача успешно обновлена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID задачи"),
     *             @OA\Property(property="name", type="string", description="Название задачи"),
     *             @OA\Property(property="description", type="string", description="Описание задачи"),
     *             @OA\Property(property="status_id", type="integer", description="ID статуса задачи"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя, назначенного на задачу"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния задачи"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания задачи"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления задачи")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные данные",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Задача не найдена",
     *         @OA\JsonContent()
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

        if ($request->has('projects')) {
            $task->projects()->sync($validated['projects']);
        }

        event(new \App\Events\TaskUpdated($task));

        return response()->json([
            'message' => 'Задача успешно обновлена!',
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
     *         description="Задача успешно удалена",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Задача не найдена",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Задача успешно удалена']);
    }
}
