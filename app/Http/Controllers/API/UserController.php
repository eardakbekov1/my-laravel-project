<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="User API",
 *     version="1.0.0",
 *     description="API для работы с пользователями"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Получить список всех пользователей",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получен список пользователей",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $users = User::with('condition')->get();
        return response()->json($users);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Создать нового пользователя",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Пользователь успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/User")
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
        // Валидация и создание пользователя
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Получить информацию о пользователе",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно получена информация о пользователе",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пользователь не найден",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::with('condition')->findOrFail($id);
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Обновить данные пользователя",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь успешно обновлен",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Валидация и обновление пользователя
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Удалить пользователя",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пользователь успешно удален"
     *     )
     * )
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Пользователь успешно удален!']);
    }

    /**
     * @OA\Schema(
     *     schema="UserCreateRequest",
     *     type="object",
     *     required={"first_name", "last_name", "username", "email", "password"},
     *     @OA\Property(property="first_name", type="string", description="Имя"),
     *     @OA\Property(property="last_name", type="string", description="Фамилия"),
     *     @OA\Property(property="username", type="string", description="Логин"),
     *     @OA\Property(property="email", type="string", description="Email"),
     *     @OA\Property(property="password", type="string", description="Пароль"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния пользователя")
     * )
     */

    /**
     * @OA\Schema(
     *     schema="UserUpdateRequest",
     *     type="object",
     *     required={"first_name", "last_name", "username", "email"},
     *     @OA\Property(property="first_name", type="string", description="Имя"),
     *     @OA\Property(property="last_name", type="string", description="Фамилия"),
     *     @OA\Property(property="username", type="string", description="Логин"),
     *     @OA\Property(property="email", type="string", description="Email"),
     *     @OA\Property(property="password", type="string", description="Пароль"),
     *     @OA\Property(property="condition_id", type="integer", description="ID состояния пользователя")
     * )
     */
}
