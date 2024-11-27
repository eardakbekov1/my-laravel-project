<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Status API",
 *     version="1.0.0",
 *     description="API для работы со статусами"
 * )
 */
class StatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/statuses",
     *     summary="Получить список всех статусов",
     *     tags={"Statuses"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получен список статусов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Status")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $statuses = Status::with('condition')->get(); // Получаем статусы с их состояниями
        return response()->json($statuses);
    }

    /**
     * @OA\Post(
     *     path="/api/statuses",
     *     summary="Создать новый статус",
     *     tags={"Statuses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StatusCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Статус успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
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
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $status = Status::create($validated);

        return response()->json([
            'message' => 'Статус успешно создан!',
            'data' => $status->load('condition'),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/statuses/{id}",
     *     summary="Показать конкретный статус",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получен статус",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Статус не найден",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(Status $status)
    {
        $status->load('condition'); // Подгружаем состояние
        return response()->json($status);
    }

    /**
     * @OA\Put(
     *     path="/api/statuses/{id}",
     *     summary="Обновить статус",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StatusUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Статус успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/statuses/{id}",
     *     summary="Удалить статус",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Статус успешно удален"
     *     )
     * )
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return response()->json([
            'message' => 'Статус удален успешно!',
        ]);
    }

    /**
     * @OA\Schema(
     *     schema="StatusCreateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название статуса"),
     *     @OA\Property(property="description", type="string", description="Описание статуса"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="StatusUpdateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название статуса"),
     *     @OA\Property(property="description", type="string", description="Описание статуса"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Status",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="ID статуса"),
     *     @OA\Property(property="name", type="string", description="Название статуса"),
     *     @OA\Property(property="description", type="string", description="Описание статуса"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния"),
     *     @OA\Property(property="condition", ref="#/components/schemas/Condition")
     * )
     */
}
