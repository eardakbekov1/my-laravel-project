<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Condition;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Получить список ролей",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получен список ролей",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="ID роли"),
     *                 @OA\Property(property="name", type="string", description="Название роли"),
     *                 @OA\Property(property="description", type="string", description="Описание роли"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания роли"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления роли")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $roles = Role::with('condition')->get(); // Получаем роли с их состояниями
        return response()->json($roles);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Создать новую роль",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Название роли"),
     *             @OA\Property(property="description", type="string", description="Описание роли"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния роли")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Роль успешно создана",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID роли"),
     *             @OA\Property(property="name", type="string", description="Название роли"),
     *             @OA\Property(property="description", type="string", description="Описание роли"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания роли"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления роли"),
     *             @OA\Property(property="condition", type="object", description="Состояние роли",
     *                 @OA\Property(property="id", type="integer", description="ID состояния"),
     *                 @OA\Property(property="name", type="string", description="Название состояния")
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

        $role = Role::create($validated);

        return response()->json([
            'message' => 'Роль успешно создана!',
            'data' => $role->load('condition'),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     summary="Показать конкретную роль",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получена роль",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID роли"),
     *             @OA\Property(property="name", type="string", description="Название роли"),
     *             @OA\Property(property="description", type="string", description="Описание роли"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания роли"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления роли"),
     *             @OA\Property(property="condition", type="object", description="Состояние роли",
     *                 @OA\Property(property="id", type="integer", description="ID состояния"),
     *                 @OA\Property(property="name", type="string", description="Название состояния")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Роль не найдена",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(Role $role)
    {
        $role->load('condition'); // Подгружаем состояние
        return response()->json($role);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Обновить роль",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Название роли"),
     *             @OA\Property(property="description", type="string", description="Описание роли"),
     *             @OA\Property(property="condition_id", type="integer", description="ID состояния роли")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Роль успешно обновлена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID роли"),
     *             @OA\Property(property="name", type="string", description="Название роли"),
     *             @OA\Property(property="description", type="string", description="Описание роли"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания роли"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Дата последнего обновления роли"),
     *             @OA\Property(property="condition", type="object", description="Состояние роли",
     *                 @OA\Property(property="id", type="integer", description="ID состояния"),
     *                 @OA\Property(property="name", type="string", description="Название состояния")
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $role->update($validated);

        return response()->json([
            'message' => 'Роль успешно обновлена!',
            'data' => $role->load('condition'),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Удалить роль",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Роль успешно удалена"
     *     )
     * )
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Роль успешно удалена!',
        ]);
    }
}
