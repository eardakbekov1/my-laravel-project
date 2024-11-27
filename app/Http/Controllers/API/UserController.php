<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Получить список всех пользователей.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::with('condition')->get(); // Загружаем связанные состояния

        return response()->json($users);
    }

    /**
     * Создать нового пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'condition_id' => $validated['condition_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'Пользователь успешно создан!',
            'data' => $user->load('condition'),
        ], 201);
    }

    /**
     * Получить информацию о пользователе.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::with('condition')->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Обновить пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        if ($request->password) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return response()->json([
            'message' => 'Пользователь успешно обновлен!',
            'data' => $user->load('condition'),
        ]);
    }

    /**
     * Удалить пользователя.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        User::destroy($id);

        return response()->json([
            'message' => 'Пользователь успешно удален!',
        ]);
    }
}
