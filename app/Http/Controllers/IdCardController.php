<?php

namespace App\Http\Controllers;

use App\Models\IdCard;
use App\Models\Role;
use App\Models\User;
use App\Models\Condition;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    public function index()
    {
        $idCards = IdCard::with(['role', 'user', 'condition'])->get();
        return view('id_cards.index', compact('idCards'));
    }

    public function create()
    {
        $roles = Role::all();
        $users = User::all();
        $conditions = Condition::all();
        return view('id_cards.create', compact('roles', 'users', 'conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        IdCard::create($validated);

        return redirect()->route('id_cards.index')->with('success', 'ID-карта успешно создана!');
    }

    public function show(IdCard $idCard)
    {
        return view('id_cards.show', compact('idCard'));
    }

    public function edit(IdCard $idCard)
    {
        $roles = Role::all();
        $users = User::all();
        $conditions = Condition::all();
        return view('id_cards.edit', compact('idCard', 'roles', 'users', 'conditions'));
    }

    public function update(Request $request, IdCard $idCard)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
            'condition_id' => 'nullable|exists:conditions,id',
        ]);

        $idCard->update($validated);

        return redirect()->route('id_cards.index')->with('success', 'ID-карта успешно обновлена!');
    }

    public function destroy(IdCard $idCard)
    {
        $idCard->delete();
        return redirect()->route('id_cards.index')->with('success', 'ID-карта успешно удалена!');
    }
}
