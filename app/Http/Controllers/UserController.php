<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Отображение списка пользователей
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Отображение формы для создания нового пользователя
    public function create()
    {
        $conditions = Condition::all();  // Получаем все состояния из базы данных
        return view('users.create', compact('conditions'));
    }

    // Сохранение нового пользователя
    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);
        \Log::info($request->all());  // Выведет все данные, которые приходят из формы

        // Создание нового пользователя
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Шифрование пароля
        $user->condition_id = $request->input('condition_id'); // Состояние (если выбрано)
        $user->save(); // Сохраняем пользователя

        // Перенаправляем с сообщением об успехе
        return redirect()->route('users.index')->with('success', 'Пользователь успешно создан!');
    }

    // Отображение формы для редактирования пользователя
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $conditions = Condition::all();
        return view('users.edit', compact('user', 'conditions'));
    }

    // Обновление пользователя
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        if ($request->password) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return redirect()->route('users.index');
    }

    // Отображение деталей пользователя
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Удаление пользователя
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }
}
