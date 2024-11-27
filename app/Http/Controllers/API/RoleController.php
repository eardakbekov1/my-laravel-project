<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Condition;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Role API",
 *     version="1.0.0",
 *     description="API для работы с ролями"
 * )
 */
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
     *             @OA\Items(ref="#/components/schemas/Role")
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
     *         @OA\JsonContent(ref="#/components/schemas/RoleCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Роль успешно создана",
     *         @OA\JsonContent(ref="#/components/schemas/Role")
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
     *         @OA\JsonContent(ref="#/components/schemas/Role")
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
     *         @OA\JsonContent(ref="#/components/schemas/RoleUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Роль успешно обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Role")
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

    /**
     * @OA\Schema(
     *     schema="RoleCreateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название роли"),
     *     @OA\Property(property="description", type="string", description="Описание роли"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="RoleUpdateRequest",
     *     type="object",
     *     required={"name"},
     *     @OA\Property(property="name", type="string", description="Название роли"),
     *     @OA\Property(property="description", type="string", description="Описание роли"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="Role",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="ID роли"),
     *     @OA\Property(property="name", type="string", description="Название роли"),
     *     @OA\Property(property="description", type="string", description="Описание роли"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния"),
     *     @OA\Property(property="condition", ref="#/components/schemas/Condition")
     * )
     */
}
