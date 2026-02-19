<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Opportunity::with(['status', 'assignee', 'creator', 'team']);

        if ($user->isLead()) {
            $query->where('team_id', $user->team_id);
        } elseif ($user->isAgentConseil()) {
            $query->where('assigned_to', $user->id);
        } elseif ($user->isAgentTerrain()) {
            $query->where('created_by', $user->id);
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('prenoms', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('plaque_immatriculation', 'like', "%{$search}%");
            });
        }

        $opportunities = $query->latest()->paginate(15)->withQueryString();
        $statuses = Status::orderBy('order')->get();

        return view('opportunities.index', compact('opportunities', 'statuses'));
    }

    public function listNewOpportunities()
    {
        $newStatus = Status::where('slug', 'nouvelle')->first();

        $query = Opportunity::with(['status', 'assignee', 'creator', 'team']);

        if ($newStatus) {
            $query->where('status_id', $newStatus->id);
        }

        $opportunities = $query->latest()->paginate(15);
        $statuses = Status::orderBy('order')->get();

        return view('opportunities.index', compact('opportunities', 'statuses'));
    }



    public function create()
    {
        $this->authorize('create', Opportunity::class);

        return view('opportunities.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Opportunity::class);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'telephone2' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'observation' => 'nullable|string',
            'source' => 'nullable|string|max:255',
            'canal' => 'nullable|string|max:255',
            'plaque_immatriculation' => 'nullable|string|max:255',
            'echeance' => 'nullable|date',
            'lieuprospection' => 'nullable|string|max:255',
            'assureur_actuel' => 'nullable|string|max:255',
            'periode_souscription' => 'nullable|integer',
            'montant_souscription' => 'nullable|integer',
            'isasap' => 'nullable|string|max:255',
            'urlcarte_grise_terrain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_attestationassurance_terrain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['created_by'] = $request->user()->id;
        $validated['status_id'] = Status::where('slug', 'nouvelle')->first()->id;
        $validated['team_id'] = $request->user()->team_id;

        if ($request->hasFile('urlcarte_grise_terrain')) {
            $validated['urlcarte_grise_terrain'] = $request->file('urlcarte_grise_terrain')->store('documents/cartes_grises', 'public');
        }
        if ($request->hasFile('url_attestationassurance_terrain')) {
            $validated['url_attestationassurance_terrain'] = $request->file('url_attestationassurance_terrain')->store('documents/attestations', 'public');
        }

        Opportunity::create($validated);

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunité créée avec succès.');
    }

    public function show(Opportunity $opportunity)
    {
        $this->authorize('view', $opportunity);

        $opportunity->load(['status', 'assignee', 'creator', 'team', 'comments.user', 'assignments.assigner', 'assignments.assignee']);

        $conseilUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_conseil'))
            ->when(auth()->user()->isLead(), fn($q) => $q->where('team_id', auth()->user()->team_id))
            ->get();

        $statuses = Status::orderBy('order')->get();

        return view('opportunities.show', compact('opportunity', 'conseilUsers', 'statuses'));
    }

    public function edit(Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        $statuses = Status::orderBy('order')->get();

        return view('opportunities.edit', compact('opportunity', 'statuses'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'telephone2' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'observation' => 'nullable|string',
            'source' => 'nullable|string|max:255',
            'canal' => 'nullable|string|max:255',
            'plaque_immatriculation' => 'nullable|string|max:255',
            'echeance' => 'nullable|date',
            'lieuprospection' => 'nullable|string|max:255',
            'assureur_actuel' => 'nullable|string|max:255',
            'periode_souscription' => 'nullable|integer',
            'montant_souscription' => 'nullable|integer',
            'isasap' => 'nullable|string|max:255',
            'urlcarte_grise_terrain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_attestationassurance_terrain' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'urlcarte_grise' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_attestationassurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'statut_discours' => 'nullable|string|max:255',
            'statut_carte_grise' => 'nullable|string|max:255',
            'statut_attestation' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('urlcarte_grise_terrain')) {
            if ($opportunity->urlcarte_grise_terrain) {
                Storage::disk('public')->delete($opportunity->urlcarte_grise_terrain);
            }
            $validated['urlcarte_grise_terrain'] = $request->file('urlcarte_grise_terrain')->store('documents/cartes_grises', 'public');
        }
        if ($request->hasFile('url_attestationassurance_terrain')) {
            if ($opportunity->url_attestationassurance_terrain) {
                Storage::disk('public')->delete($opportunity->url_attestationassurance_terrain);
            }
            $validated['url_attestationassurance_terrain'] = $request->file('url_attestationassurance_terrain')->store('documents/attestations', 'public');
        }
        if ($request->hasFile('urlcarte_grise')) {
            if ($opportunity->urlcarte_grise) {
                Storage::disk('public')->delete($opportunity->urlcarte_grise);
            }
            $validated['urlcarte_grise'] = $request->file('urlcarte_grise')->store('documents/cartes_grises_bo', 'public');
        }
        if ($request->hasFile('url_attestationassurance')) {
            if ($opportunity->url_attestationassurance) {
                Storage::disk('public')->delete($opportunity->url_attestationassurance);
            }
            $validated['url_attestationassurance'] = $request->file('url_attestationassurance')->store('documents/attestations_bo', 'public');
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
            'status_id' => Status::where('slug', 'rendez_vous')->first()->id,
        ]);

        Assignment::create([
            'opportunity_id' => $opportunity->id,
            'assigned_by' => $request->user()->id,
            'assigned_to' => $validated['assigned_to'],
        ]);

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Opportunité affectée avec succès.');
    }

    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'opportunity_ids' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ids = array_filter(explode(',', $validated['opportunity_ids']));

        if (empty($ids)) {
            return redirect()->route('opportunities.index')
                ->with('error', 'Aucune opportunité sélectionnée.');
        }

        Opportunity::whereIn('id', $ids)->update(['assigned_to' => $validated['assigned_to']]);

        $count = count($ids);
        return redirect()->route('opportunities.index')
            ->with('success', $count . ' opportunité(s) affectée(s) avec succès.');
    }

    public function changeStatus(Request $request, Opportunity $opportunity)
    {
        $this->authorize('changeStatus', $opportunity);

        $validated = $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $newStatus = Status::find($validated['status_id']);
        $opportunity->update(['status_id' => $validated['status_id']]);

        // Si le statut passe à "Gagné", créer le client automatiquement
        if ($newStatus->slug === 'gagne' && !$opportunity->client_id) {
            $client = Client::firstOrCreate(
                [
                    'telephone' => $opportunity->telephone,
                ],
                [
                    'nom' => $opportunity->nom,
                    'prenoms' => $opportunity->prenoms,
                    'telephone2' => $opportunity->telephone2,
                    'plaque_immatriculation' => $opportunity->plaque_immatriculation,
                    'assureur_actuel' => $opportunity->assureur_actuel,
                    'lieuprospection' => $opportunity->lieuprospection,
                ]
            );

            $opportunity->update(['client_id' => $client->id]);

            return redirect()->route('opportunities.show', $opportunity)
                ->with('success', 'Statut mis à jour. Client "' . $client->full_name . '" créé automatiquement.');
        }

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Statut mis à jour.');
    }
}
