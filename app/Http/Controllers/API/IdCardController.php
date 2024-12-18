<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IdCard;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/id-cards",
     *     summary="Получить список всех ID-карт",
     *     tags={"IdCards"},
     *     @OA\Response(
     *         response=200,
     *         description="Список всех ID-карт успешно получен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID ID-карты"),
     *                 @OA\Property(property="user_id", type="integer", description="ID пользователя, которому принадлежит ID-карта"),
     *                 @OA\Property(property="card_number", type="string", description="Номер ID-карты"),
     *                 @OA\Property(property="issued_at", type="string", format="date-time", description="Дата выдачи ID-карты"),
     *                 @OA\Property(property="expires_at", type="string", format="date-time", description="Дата окончания срока действия ID-карты")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $idCards = IdCard::with(['role', 'user', 'condition'])->get();
        return response()->json($idCards);
    }

    /**
     * @OA\Post(
     *     path="/api/id-cards",
     *     summary="Создать новую ID-карту",
     *     tags={"IdCards"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="role_id", type="integer", description="ID роли"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя, которому принадлежит ID-карта"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния (необязательно)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="ID-карта успешно создана",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID ID-карты"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя"),
     *             @OA\Property(property="card_number", type="string", description="Номер ID-карты"),
     *             @OA\Property(property="issued_at", type="string", format="date-time", description="Дата выдачи ID-карты"),
     *             @OA\Property(property="expires_at", type="string", format="date-time", description="Дата окончания срока действия ID-карты")
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
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $idCard = IdCard::create($validated);

        return response()->json([
            'message' => 'ID-карта успешно создана!',
            'data' => $idCard,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/id-cards/{id}",
     *     summary="Получить данные о конкретной ID-карте",
     *     tags={"IdCards"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Данные ID-карты успешно получены",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID ID-карты"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя"),
     *             @OA\Property(property="card_number", type="string", description="Номер ID-карты"),
     *             @OA\Property(property="issued_at", type="string", format="date-time", description="Дата выдачи ID-карты"),
     *             @OA\Property(property="expires_at", type="string", format="date-time", description="Дата окончания срока действия ID-карты")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ID-карта не найдена",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(IdCard $idCard)
    {
        $idCard->load(['role', 'user', 'condition']);
        return response()->json($idCard);
    }

    /**
     * @OA\Put(
     *     path="/api/id-cards/{id}",
     *     summary="Обновить данные ID-карты",
     *     tags={"IdCards"},
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
     *             @OA\Property(property="role_id", type="integer", description="ID роли"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния (необязательно)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ID-карта успешно обновлена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID ID-карты"),
     *             @OA\Property(property="user_id", type="integer", description="ID пользователя"),
     *             @OA\Property(property="card_number", type="string", description="Номер ID-карты"),
     *             @OA\Property(property="issued_at", type="string", format="date-time", description="Дата выдачи ID-карты"),
     *             @OA\Property(property="expires_at", type="string", format="date-time", description="Дата окончания срока действия ID-карты")
     *         )
     *     )
     * )
     */
    public function update(Request $request, IdCard $idCard)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $idCard->update($validated);

        return response()->json([
            'message' => 'ID-карта успешно обновлена!',
            'data' => $idCard,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/id-cards/{id}",
     *     summary="Удалить ID-карту",
     *     tags={"IdCards"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ID-карта успешно удалена"
     *     )
     * )
     */
    public function destroy(IdCard $idCard)
    {
        $idCard->delete();

        return response()->json([
            'message' => 'ID-карта успешно удалена!',
        ]);
    }
}
