<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('users')->get();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Team::create($validated);

        return redirect()->route('teams.index')
            ->with('success', 'Équipe créée avec succès.');
    }

    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team->update($validated);

        return redirect()->route('teams.index')
            ->with('success', 'Équipe mise à jour.');
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Équipe supprimée.');
    }
}
