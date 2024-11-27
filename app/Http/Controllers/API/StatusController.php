<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\Condition;
use Illuminate\Http\Request;

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
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID статуса"),
     *                 @OA\Property(property="name", type="string", description="Название статуса"),
     *                 @OA\Property(property="description", type="string", description="Описание статуса"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания статуса"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления статуса"),
     *                 @OA\Property(property="condition", type="object",
     *                     @OA\Property(property="id", type="integer", description="ID состояния"),
     *                     @OA\Property(property="name", type="string", description="Название состояния")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $statuses = Status::with('condition')->get();
        return response()->json($statuses);
    }

    /**
     * @OA\Post(
     *     path="/api/statuses",
     *     summary="Создать новый статус",
     *     tags={"Statuses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Название статуса"),
     *             @OA\Property(property="description", type="string", description="Описание статуса"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Статус успешно создан",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", description="Сообщение об успешном создании статуса"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID статуса"),
     *                 @OA\Property(property="name", type="string", description="Название статуса"),
     *                 @OA\Property(property="description", type="string", description="Описание статуса"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания статуса"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления статуса"),
     *                 @OA\Property(property="condition", type="object",
     *                     @OA\Property(property="id", type="integer", description="ID состояния"),
     *                     @OA\Property(property="name", type="string", description="Название состояния")
     *                 )
     *             )
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
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID статуса"),
     *             @OA\Property(property="name", type="string", description="Название статуса"),
     *             @OA\Property(property="description", type="string", description="Описание статуса"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания статуса"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления статуса"),
     *             @OA\Property(property="condition", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID состояния"),
     *                 @OA\Property(property="name", type="string", description="Название состояния")
     *             )
     *         )
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
        $status->load('condition');
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
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", description="Название статуса"),
     *             @OA\Property(property="description", type="string", description="Описание статуса"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Статус успешно обновлен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID статуса"),
     *             @OA\Property(property="name", type="string", description="Название статуса"),
     *             @OA\Property(property="description", type="string", description="Описание статуса"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания статуса"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления статуса"),
     *             @OA\Property(property="condition", type="object",
     *                 @OA\Property(property="id", type="integer", description="ID состояния"),
     *                 @OA\Property(property="name", type="string", description="Название состояния")
     *             )
     *         )
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
}
