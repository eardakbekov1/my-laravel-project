<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    /**
     * Показать список всех состояний.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $conditions = Condition::all(); // Получаем все состояния
        return response()->json($conditions);
    }

    /**
     * Сохранить новое состояние.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Создание состояния
        $condition = Condition::create($validated);

        return response()->json([
            'message' => 'Состояние создано успешно!',
            'data' => $condition,
        ], 201);
    }

    /**
     * Показать информацию о состоянии.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $condition = Condition::findOrFail($id); // Находим состояние по ID
        return response()->json($condition);
    }

    /**
     * Обновить состояние.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $condition = Condition::findOrFail($id);
        $condition->update($validated);

        return response()->json([
            'message' => 'Состояние обновлено успешно!',
            'data' => $condition,
        ]);
    }

    /**
     * Удалить состояние.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $condition = Condition::findOrFail($id);
        $condition->delete();

        return response()->json([
            'message' => 'Состояние удалено успешно!',
        ]);
    }
}
