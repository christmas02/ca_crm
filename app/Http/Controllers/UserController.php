<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'team'])->orderBy('name')->paginate(20);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $teams = Team::all();

        return view('users.create', compact('roles', 'teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identification' => 'required|string|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $teams = Team::all();

        return view('users.edit', compact('user', 'roles', 'teams'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identification' => 'required|string|max:255|unique:users,identification,' . $user->id,
            'password' => ['nullable', Rules\Password::defaults()],
            'role_id' => 'required|exists:roles,id',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}
