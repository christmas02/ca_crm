<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class OpportunityController extends Controller
{
    /**
     * Méthode de traitement des fichiers
     * 
     * @param \Illuminate\Http\UploadedFile $file - Le fichier à traiter
     * @param string $folder - Le dossier de destination (ex: 'documents/cartes_grises')
     * @return string - Le chemin du fichier stocké
     */
    private function storeFile($file, $folder)
    {
        try {
            if (!$file || !$file->isValid()) {
                Log::warning('Fichier invalide: ' . ($file ? $file->getErrorMessage() : 'aucun fichier'));
                return null;
            }

            $path = $file->store($folder, 'public');
            Log::info('Fichier stocké avec succès: ' . $path);
            return $path;
        } catch (\Exception $e) {
            Log::error('Erreur lors du stockage du fichier: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Méthode pour supprimer un fichier
     * 
     * @param string $filePath - Le chemin du fichier à supprimer
     * @return bool - Vrai si suppression réussie
     */
    private function deleteFile($filePath)
    {
        try {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                Log::info('Fichier supprimé avec succès: ' . $filePath);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du fichier: ' . $e->getMessage());
            return false;
        }
    }
    
    public function index(Request $request)
    {
        // 1. Récupère l'utilisateur connecté
        $user = $request->user();
        
        // 2. Crée une requête de base avec les relations
        $query = Opportunity::with(['status', 'assignee', 'creator', 'team']);

        // 3. FILTRAGE PAR RÔLE - Affiche les données différentes selon le rôle
        if ($user->isLead()) {
            // Si c'est un Lead : affiche toutes les opportunités de son équipe
            $query->where('team_id', $user->team_id);
            
        } elseif ($user->isAgentConseil()) {
            // Si c'est un Agent Conseil : affiche seulement ses opportunités assignées
            $query->where('assigned_to', $user->id);
            
        } elseif ($user->isAgentTerrain()) {
            // Si c'est un Agent Terrain : affiche seulement celles qu'il a créées
            $query->where('created_by', $user->id);
        }
        // Sinon (Admin) : affiche tout

        // 4. FILTRAGE PAR STATUT (optionnel)
        // Si l'utilisateur a sélectionné un statut dans le formulaire
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        
        // 5. RECHERCHE (optionnel)
        // Si l'utilisateur a entré du texte dans la recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cherche dans: titre, nom, prénom, téléphone, plaque immatriculation
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('prenoms', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('plaque_immatriculation', 'like', "%{$search}%");
            });
        }

        // 6. RÉSULTATS
        // Récupère les opportunités (triées par plus récentes) avec pagination 15 par page
        $opportunities = $query->latest()->paginate(15)->withQueryString();
        
        // Récupère tous les statuts pour afficher dans les filtres
        $statuses = Status::orderBy('order')->orderBy('name')->get();

        // Affiche la vue avec les données
        return view('opportunities.index', compact('opportunities', 'statuses'));
    }

    public function listNewOpportunities()
    {
        // 1. Récupère l'utilisateur connecté (le conseil)
        $user = auth()->user();
        // 2. Obtient la date d'aujourd'hui (minuit) pour les comparaisons
        $today = now()->startOfDay();

        // 3. Construit une requête complexe
        // Récupère les IDs des statuts à exclure
        $excludeStatusIds = Status::whereIn('slug', ['gagne', 'perdus'])->pluck('id')->toArray();

        $query = Opportunity::with(['status', 'assignee', 'creator', 'team'])
            // Joins la table assignments pour accéder aux données d'assignation
            ->join('assignments', 'opportunities.id', '=', 'assignments.opportunity_id')
            // Filtre: seulement les opportunités assignées AU consultant connecté
            ->where('assignments.assigned_to', $user->id)
            // Filtre: seulement les assignations actives (pas les anciennes)
            ->where('assignments.status', 'active')
            // Filtre: exclure les statuts "Gagné" et "Perdus"
            ->whereNotIn('opportunities.status_id', $excludeStatusIds);

            // Affiche l'opportunité si elle remplit AU MOINS UNE de ces conditions:
        $query->where(function ($q) use ($today) {
            // Condition 1: Date de relance <= aujourd'hui (en retard/à relancer)
            $q->where(function ($subQ) use ($today) {
                $subQ->whereNotNull('opportunities.relance')
                     ->where('opportunities.relance', '<=', $today);
            })
            // Condition 2: Date d'affectation (assignation) <= aujourd'hui (assignée depuis longtemps)
            ->orWhere('assignments.date_affect', '<=', $today)
            // Condition 3: Date d'écheance <= aujourd'hui (en retard/expirée)
            ->orWhere(function ($subQ) use ($today) {
                $subQ->whereNotNull('opportunities.echeance')
                     ->where('opportunities.echeance', '<=', $today);
            });
        })->select('opportunities.*');

        // 5. Récupère les résultats avec pagination (15 par page)
        $opportunities = $query->latest('opportunities.updated_at')->paginate(15);
        
        // 6. Récupère tous les statuts disponibles pour les filtres
        $statuses = Status::orderBy('order')->orderBy('name')->get();

        // 7. Affiche la vue avec les opportunités et statuts
        return view('opportunities.index', compact('opportunities', 'statuses'));
    }



    public function create()
    {
        $this->authorize('create', Opportunity::class);

        return view('opportunities.create');
    }

    public function store(Request $request)
    {
        try {  
            $this->authorize('create', Opportunity::class);
            
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenoms' => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'observation' => 'nullable|string',
                'canal' => 'nullable|string|max:255',
                'plaque_immatriculation' => 'nullable|string|max:255',
                'echeance' => 'nullable|date',
                'lieuprospection' => 'nullable|string|max:255',
                'assureur_actuel' => 'nullable|string|max:255',
                'isasap' => 'nullable|string|max:255',
                'urlcarte_grise' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'url_attestationassurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);

            $validated['created_by'] = $request->user()->id;
            $validated['status_id'] = Status::where('slug', 'nouvelle')->first()->id;
            $validated['team_id'] = $request->user()->team_id;

            if ($request->hasFile('urlcarte_grise')) {
                $validated['urlcarte_grise'] = $this->storeFile($request->file('urlcarte_grise'), 'documents/cartes_grises');
            }
            if ($request->hasFile('url_attestationassurance')) {
                $validated['url_attestationassurance'] = $this->storeFile($request->file('url_attestationassurance'), 'documents/attestations');
            }

            Opportunity::create($validated);
            Log::info('Opportunité créée avec succès par l\'utilisateur ID: ' . $request->user()->id);

            return redirect()->route('opportunities.new')
                ->with('success', 'Opportunité créée avec succès.');
                
        } catch (\Exception $e) {
            // Autres erreurs
            Log::error('Erreur lors de la création d\'opportunité: ' . $e->getMessage());
            return redirect()->route('opportunities.create')
                ->withInput($request->all())
                ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function show(Opportunity $opportunity)
    {
        $this->authorize('view', $opportunity);

        $opportunity->load(['status', 'assignee', 'creator', 'team', 'comments.user', 'assignments.assigner', 'assignments.assignee']);

        $conseilUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_conseil'))
            ->when(auth()->user()->isLead(), fn($q) => $q->where('team_id', auth()->user()->team_id))
            ->get();

        $statuses = Status::orderBy('order')->orderBy('name')->get();

        return view('opportunities.show', compact('opportunity', 'conseilUsers', 'statuses'));
    }

    public function edit(Opportunity $opportunity)
    {
        $this->authorize('update', $opportunity);

        $statuses = Status::orderBy('order')->orderBy('name')->get();

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
            'observation' => 'nullable|string',
            'canal' => 'nullable|string|max:255',
            'plaque_immatriculation' => 'nullable|string|max:255',
            'echeance' => 'nullable|date',
            'lieuprospection' => 'nullable|string|max:255',
            'assureur_actuel' => 'nullable|string|max:255',
            'periode_souscription' => 'nullable|integer',
            'montant_souscription' => 'nullable|integer',
            'isasap' => 'nullable|string|max:255',
            'urlcarte_grise' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'url_attestationassurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'statut_discours' => 'nullable|string|max:255',
            'statut_carte_grise' => 'nullable|string|max:255',
            'statut_attestation' => 'nullable|string|max:255',
            'daterelance' => 'nullable|date',
            'status_id' => 'nullable|exists:statuses,id',
            'montant_nette_prime' => 'nullable|numeric',
            'montant_ttc' => 'nullable|numeric',
            'carte_grise_client' => 'nullable|string|max:255',
            'atd_client' => 'nullable|string|max:255',
            'contrat_assurance' => 'nullable|string|max:255',
            'duree_contrat' => 'nullable|string|max:255',
            'capture_paiement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Gestion fichier carte grise back-office
        if ($request->hasFile('urlcarte_grise')) {
            $this->deleteFile($opportunity->urlcarte_grise);
            $validated['urlcarte_grise'] = $this->storeFile($request->file('urlcarte_grise'), 'documents/cartes_grises_bo');
        } else {
            // Si pas de nouveau fichier, garder l'existant
            $validated['urlcarte_grise'] = $opportunity->urlcarte_grise;
        }

        // Gestion fichier attestation back-office
        if ($request->hasFile('url_attestationassurance')) {
            $this->deleteFile($opportunity->url_attestationassurance);
            $validated['url_attestationassurance'] = $this->storeFile($request->file('url_attestationassurance'), 'documents/attestations_bo');
        } else {
            // Si pas de nouveau fichier, garder l'existant
            $validated['url_attestationassurance'] = $opportunity->url_attestationassurance;
        }

        // Gestion fichier capture paiement (pour Client Gagné)
        if ($request->hasFile('capture_paiement')) {
            if ($opportunity->capture_paiement) {
                $this->deleteFile($opportunity->capture_paiement);
            }
            $validated['capture_paiement'] = $this->storeFile($request->file('capture_paiement'), 'documents/captures_paiement');
        } else {
            // Si pas de nouveau fichier, garder l'existant
            $validated['capture_paiement'] = $opportunity->capture_paiement ?? null;
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

        // Vérifier s'il existe une assignation active et la mettre à inactive
        Assignment::where('opportunity_id', $opportunity->id)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $opportunity->update([
            'assigned_to' => $validated['assigned_to'],
            'status_id' => Status::where('slug', 'rendez_vous')->first()->id,
        ]);

        // Créer la nouvelle assignation
        Assignment::create([
            'opportunity_id' => $opportunity->id,
            'assigned_by' => $request->user()->id,
            'assigned_to' => $validated['assigned_to'],
            'status' => 'active',
            'date_affect' => now(),
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

        // Créer les assignations pour chaque opportunité
        foreach ($ids as $opportunityId) {
            // Mettre les assignations actives existantes à inactive
            Assignment::where('opportunity_id', $opportunityId)
                ->where('status', 'active')
                ->update(['status' => 'inactive']);

            // Créer la nouvelle assignation
            Assignment::create([
                'opportunity_id' => $opportunityId,
                'assigned_by' => $request->user()->id,
                'assigned_to' => $validated['assigned_to'],
                'status' => 'active',
                'date_affect' => now(),
            ]);
        }

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
