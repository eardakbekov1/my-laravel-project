<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    /**
     * Показать список всех состояний.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conditions = Condition::all(); // Получаем все состояния
        return view('conditions.index', compact('conditions'));
    }

    /**
     * Показать форму для создания нового состояния.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('conditions.create');
    }

    /**
     * Сохранить новое состояние.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Создание состояния
        Condition::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('conditions.index')->with('success', 'Состояние создано успешно!');
    }

    /**
     * Показать форму для редактирования состояния.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $condition = Condition::findOrFail($id); // Находим состояние по ID
        return view('conditions.edit', compact('condition'));
    }

    /**
     * Обновить состояние.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $condition = Condition::findOrFail($id);
        $condition->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('conditions.index')->with('success', 'Состояние обновлено успешно!');
    }

    /**
     * Показать информацию о состоянии.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $condition = Condition::findOrFail($id); // Находим состояние по ID
        return view('conditions.show', compact('condition'));
    }

    /**
     * Удалить состояние.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $condition = Condition::findOrFail($id);
        $condition->delete();

        return redirect()->route('conditions.index')->with('success', 'Состояние удалено успешно!');
    }
}
