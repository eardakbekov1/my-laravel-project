<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IdCard;
use App\Models\Role;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    /**
     * Получить список всех ID-карт.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $idCards = IdCard::with(['role', 'user', 'condition'])->get();
        return response()->json($idCards);
    }

    /**
     * Создать новую ID-карту.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Получить данные о конкретной ID-карте.
     *
     * @param  \App\Models\IdCard  $idCard
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(IdCard $idCard)
    {
        $idCard->load(['role', 'user', 'condition']); // Загружаем связанные данные
        return response()->json($idCard);
    }

    /**
     * Обновить данные ID-карты.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IdCard  $idCard
     * @return \Illuminate\Http\JsonResponse
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
     * Удалить ID-карту.
     *
     * @param  \App\Models\IdCard  $idCard
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(IdCard $idCard)
    {
        $idCard->delete();

        return response()->json([
            'message' => 'ID-карта успешно удалена!',
        ]);
    }
}
