<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Condition;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Получить список ролей.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = Role::with('condition')->get(); // Получаем роли с их состояниями
        return response()->json($roles);
    }

    /**
     * Создать новую роль.
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

        $role = Role::create($validated);

        return response()->json([
            'message' => 'Роль успешно создана!',
            'data' => $role->load('condition'),
        ], 201);
    }

    /**
     * Показать конкретную роль.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        $role->load('condition'); // Подгружаем состояние
        return response()->json($role);
    }

    /**
     * Обновить роль.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
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
     * Удалить роль.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Роль успешно удалена!',
        ]);
    }
}
