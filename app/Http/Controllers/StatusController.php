<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Condition;


class StatusController extends Controller
{
    /**
     * Показать список всех статусов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::with('condition')->get();

        return view('statuses.index', compact('statuses'));

    }

    /**
     * Показать форму для создания нового статуса.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $conditions = Condition::all(); // Получаем все состояния
        return view('statuses.create', compact('conditions'));
    }

    /**
     * Сохранить новый статус.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $status = Status::create($validated);

        return redirect()->route('statuses.index')->with('success', 'Статус успешно создан!');
    }


    /**
     * Показать форму для редактирования статуса.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = Status::findOrFail($id);
        $conditions = Condition::all(); // Получаем все состояния

        return view('statuses.edit', compact('status', 'conditions'));
    }


    /**
     * Обновить статус.
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
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $status = Status::findOrFail($id);
        $status->update($request->all());

        return redirect()->route('statuses.index')->with('success', 'Статус обновлен успешно!');
    }

    /**
     * Показать информацию о статусе.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = Status::findOrFail($id); // Находим статус по ID
        return view('statuses.show', compact('status'));
    }

    /**
     * Удалить статус.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()->route('statuses.index')->with('success', 'Статус удален успешно!');
    }
}
