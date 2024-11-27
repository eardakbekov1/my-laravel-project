<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Condition API",
 *     version="1.0.0",
 *     description="API для работы с состояниями ID-карт"
 * )
 */
class ConditionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/conditions",
     *     summary="Показать список всех состояний",
     *     tags={"Conditions"},
     *     @OA\Response(
     *         response=200,
     *         description="Список всех состояний успешно получен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Condition")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $conditions = Condition::all();
        return response()->json($conditions);
    }

    /**
     * @OA\Post(
     *     path="/api/conditions",
     *     summary="Сохранить новое состояние",
     *     tags={"Conditions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ConditionCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Состояние успешно создано",
     *         @OA\JsonContent(ref="#/components/schemas/Condition")
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
        ]);

        $condition = Condition::create($validated);

        return response()->json([
            'message' => 'Состояние создано успешно!',
            'data' => $condition,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/conditions/{id}",
     *     summary="Показать информацию о состоянии",
     *     tags={"Conditions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о состоянии получена",
     *         @OA\JsonContent(ref="#/components/schemas/Condition")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Состояние не найдено",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show($id)
    {
        $condition = Condition::findOrFail($id);
        return response()->json($condition);
    }

    /**
     * @OA\Put(
     *     path="/api/conditions/{id}",
     *     summary="Обновить состояние",
     *     tags={"Conditions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ConditionUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Состояние успешно обновлено",
     *         @OA\JsonContent(ref="#/components/schemas/Condition")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
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
     * @OA\Delete(
     *     path="/api/conditions/{id}",
     *     summary="Удалить состояние",
     *     tags={"Conditions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Состояние успешно удалено"
     *     )
     * )
     */
    public function destroy($id)
    {
        $condition = Condition::findOrFail($id);
        $condition->delete();

        return response()->json([
            'message' => 'Состояние удалено успешно!',
        ]);
    }

    /**
     * @OA\Schema(
     *     schema="ConditionCreateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название состояния"),
     *     @OA\Property(property="description", type="string", description="Описание состояния")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="ConditionUpdateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название состояния"),
     *     @OA\Property(property="description", type="string", description="Описание состояния")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Condition",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="ID состояния"),
     *     @OA\Property(property="name", type="string", description="Название состояния"),
     *     @OA\Property(property="description", type="string", description="Описание состояния")
     * )
     */
}
