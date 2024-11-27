<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Получить список всех статусов.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $statuses = Status::with('condition')->get(); // Получаем статусы с их состояниями
        return response()->json($statuses);
    }

    /**
     * Создать новый статус.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $status = Status::create($validated);

        return response()->json([
            'message' => 'Статус успешно создан!',
            'data' => $status->load('condition'),
        ], 201);
    }

    /**
     * Показать конкретный статус.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Status $status)
    {
        $status->load('condition'); // Подгружаем состояние
        return response()->json($status);
    }

    /**
     * Обновить статус.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $status->update($validated);

        return response()->json([
            'message' => 'Статус обновлен успешно!',
            'data' => $status->load('condition'),
        ]);
    }

    /**
     * Удалить статус.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return response()->json([
            'message' => 'Статус удален успешно!',
        ]);
    }
}
