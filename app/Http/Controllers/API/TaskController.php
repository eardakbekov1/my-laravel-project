<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use App\Models\Condition;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Получить список всех задач.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::with(['condition', 'status', 'user', 'projects'])->get(); // Загружаем связанные модели

        return response()->json($tasks);
    }

    /**
     * Создать новую задачу.
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
            'user_id' => 'nullable|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'projects' => 'nullable|array',
            'projects.*' => 'exists:projects,id',
        ]);

        $task = Task::create($validated); // Создаем задачу

        // Привязываем проекты, если они есть
        if ($request->has('projects')) {
            $task->projects()->sync($validated['projects']);
        }

        // Ожидаем, что событие будет обрабатываться, если нужно
        event(new \App\Events\TaskCreated($task));

        return response()->json([
            'message' => 'Задача успешно создана!',
            'data' => $task->load(['condition', 'status', 'user', 'projects']),
        ], 201);
    }

    /**
     * Показать информацию о задаче.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = Task::with(['condition', 'status', 'user', 'projects'])->findOrFail($id);

        return response()->json($task);
    }

    /**
     * Обновить задачу.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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

        $task->update($validated); // Обновление данных задачи

        // Обновляем проекты, связанные с задачей
        $task->projects()->sync($validated['projects'] ?? []);

        return response()->json([
            'message' => 'Задача обновлена успешно!',
            'data' => $task->load(['condition', 'status', 'user', 'projects']),
        ]);
    }

    /**
     * Удалить задачу.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Задача успешно удалена!',
        ]);
    }
}
