<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Condition;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Отображение списка ролей
    public function index()
    {
        $roles = Role::with('condition')->get(); // Получаем роли с состояниями
        return view('roles.index', compact('roles'));
    }

// Пример контроллера
    public function create()
    {
        $conditions = Condition::all();  // Получаем все состояния
        return view('roles.create', compact('conditions'));  // Передаем в представление
    }


    // Сохранение новой роли
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id', // предполагаем, что связь с статусами есть
        ]);

        $role = new Role($request->all());
        $role->save();

        return redirect()->route('roles.index');
    }

    // Отображение роли
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $conditions = Condition::all();  // Получаем все состояния

        return view('roles.edit', compact('role', 'conditions'));
    }

    // Обновление роли
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return redirect()->route('roles.index');
    }

    // Удаление роли
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index');
    }
}
