<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Opportunity::with(['client', 'status', 'assignee', 'creator', 'team']);

        if ($user->isLead()) {
            $query->where('team_id', $user->team_id);
        } elseif ($user->isAgentConseil()) {
            $query->where('assigned_to', $user->id);
        } elseif ($user->isAgentTerrain()) {
            $query->where('created_by', $user->id);
        }

        // Filters
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($q2) use ($search) {
                      $q2->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        $opportunities = $query->latest()->paginate(15)->withQueryString();
        $statuses = Status::orderBy('order')->get();

        return view('opportunities.index', compact('opportunities', 'statuses'));
    }

    public function create()
    {
        $this->authorize('create', Opportunity::class);

        $clients = Client::orderBy('last_name')->get();
        $statuses = Status::orderBy('order')->get();

        return view('opportunities.create', compact('clients', 'statuses'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Opportunity::class);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'source' => 'nullable|string|max:255',
            'canal' => 'nullable|string|max:255',
            'vehicle_registration' => 'nullable|string|max:255',
            'insurance_expiration_date' => 'nullable|date',
            'prospection_location' => 'nullable|string|max:255',
            'gray_card_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'attestation_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['created_by'] = $request->user()->id;
        $validated['status_id'] = Status::where('slug', 'nouvelle')->first()->id;
        $validated['team_id'] = $request->user()->team_id;

        // Handle file uploads
        if ($request->hasFile('gray_card_path')) {
            $validated['gray_card_path'] = $request->file('gray_card_path')->store('documents/gray_cards', 'public');
        }
        if ($request->hasFile('attestation_path')) {
            $validated['attestation_path'] = $request->file('attestation_path')->store('documents/attestations', 'public');
        }

        Opportunity::create($validated);

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunité créée avec succès.');
    }

    public function show(Opportunity $opportunity)
    {
        $this->authorize('view', $opportunity);

        $opportunity->load(['client', 'status', 'assignee', 'creator', 'team', 'comments.user', 'assignments.assigner', 'assignments.assignee']);

        $conseilUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_conseil'))
            ->when(auth()->user()->isLead(), fn($q) => $q->where('team_id', auth()->user()->team_id))
            ->get();

        $statuses = Status::orderBy('order')->get();

        return view('opportunities.show', compact('opportunity', 'conseilUsers', 'statuses'));
    }

    public function edit(Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        $clients = Client::orderBy('last_name')->get();
        $statuses = Status::orderBy('order')->get();

        return view('opportunities.edit', compact('opportunity', 'clients', 'statuses'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'source' => 'nullable|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'canal' => 'nullable|string|max:255',
            'vehicle_registration' => 'nullable|string|max:255',
            'insurance_expiration_date' => 'nullable|date',
            'prospection_location' => 'nullable|string|max:255',
            'gray_card_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'attestation_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Handle file uploads
        if ($request->hasFile('gray_card_path')) {
            if ($opportunity->gray_card_path) {
                \Storage::disk('public')->delete($opportunity->gray_card_path);
            }
            $validated['gray_card_path'] = $request->file('gray_card_path')->store('documents/gray_cards', 'public');
        }
        if ($request->hasFile('attestation_path')) {
            if ($opportunity->attestation_path) {
                \Storage::disk('public')->delete($opportunity->attestation_path);
            }
            $validated['attestation_path'] = $request->file('attestation_path')->store('documents/attestations', 'public');
        }

        $opportunity->update($validated);

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Opportunité mise à jour.');
    }

    public function destroy(Opportunity $opportunity)
    {
        $this->authorize('delete', $opportunity);

        $opportunity->delete();

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunité supprimée.');
    }

    public function assign(Request $request, Opportunity $opportunity)
    {
        $this->authorize('assign', $opportunity);

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $opportunity->update([
            'assigned_to' => $validated['assigned_to'],
            'status_id' => Status::where('slug', 'affecte')->first()->id,
        ]);

        Assignment::create([
            'opportunity_id' => $opportunity->id,
            'assigned_by' => $request->user()->id,
            'assigned_to' => $validated['assigned_to'],
        ]);

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Opportunité affectée avec succès.');
    }

    public function changeStatus(Request $request, Opportunity $opportunity)
    {
        $this->authorize('changeStatus', $opportunity);

        $validated = $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $opportunity->update(['status_id' => $validated['status_id']]);

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Statut mis à jour.');
    }
}
