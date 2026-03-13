<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Contract;
use App\Models\InsurancePartner;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ContractController;

class OpportunityController extends Controller
{
    /**
     * Génère un numéro de contrat unique avec suffixe si plusieurs contrats pour la même opportunité
     */
    private function generateContractNumber($opportunityId)
    {
        // Vérifier les contrats existants pour cette opportunité
        $existingContracts = Contract::where('opportunity_id', $opportunityId)->get();
        $count = $existingContracts->count();

        // Si aucun contrat existant, générer un nouveau numéro de base
        if ($count === 0) {
            return 'CTR-' . strtoupper(uniqid());
        }

        // Récupérer le contrat existant
        $lastContract = $existingContracts->last();
        $lastContractNumber = $lastContract->contract_number;

        // Extraire la base du numéro (avant le dernier suffixe -X s'il existe)
        $baseNumber = $lastContractNumber;
        if (preg_match('/-\d+$/', $lastContractNumber)) {
            // Si le dernier contrat a un suffixe, on l'enlève
            $baseNumber = preg_replace('/-\d+$/', '', $lastContractNumber);
        }

        // Générer le nouveau numéro avec le suffixe approprié
        $newCount = $count + 1;
        
        if ($newCount === 1) {
            // Premier contrat, pas de suffixe
            return $baseNumber;
        } elseif ($newCount === 2) {
            // Deuxième contrat, ajouter -2
            return $baseNumber . '-2';
        } else {
            // Troisième+ contrats, remplacer le suffixe par -newCount
            return $baseNumber . '-' . $newCount;
        }
    }

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

            // Créer le dossier s'il n'existe pas
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
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

        } elseif ($user->isAgentConseilRenouvellement()) {
            // Si c'est un Agent Conseil Renouvellement : affiche seulement les opportunités gagnées
            $gagneStatusId = Status::where('slug', 'gagne')->first()?->id;
            if ($gagneStatusId) {
                $query->where('status_id', $gagneStatusId);
            }
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

        // 6. FILTRAGE PAR PLAGE DE DATES (optionnel)
        // Filtre par date de début d'échéance
        if ($request->filled('date_start')) {
            $query->where('echeance', '>=', $request->date_start);
        }
        // Filtre par date de fin d'échéance
        if ($request->filled('date_end')) {
            $query->where('echeance', '<=', $request->date_end);
        }

        // 7. RÉSULTATS
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

        $query = Opportunity::with(['status', 'assignee', 'creator', 'team'])
            // Joins la table assignments pour accéder aux données d'assignation
            ->join('assignments', 'opportunities.id', '=', 'assignments.opportunity_id')
            // Filtre: seulement les opportunités assignées AU consultant connecté
            ->where('assignments.assigned_to', $user->id)
            // Filtre: seulement les assignations actives (pas les anciennes)
            ->where('assignments.status', 'active');

        // 3. Filtrer par statut selon le rôle
        if ($user->isAgentConseilRenouvellement()) {
            // Les autres rôles excluent "Nouvelle" et "Perdus"
            $excludeStatusIds = Status::whereIn('slug', ['nouvelle', 'perdus'])->pluck('id')->toArray();
            $query->whereNotIn('opportunities.status_id', $excludeStatusIds);
        } else {
            // Les autres rôles excluent "Gagné" et "Perdus"
            $excludeStatusIds = Status::whereIn('slug', ['gagne', 'perdus'])->pluck('id')->toArray();
            $query->whereNotIn('opportunities.status_id', $excludeStatusIds);
        }

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

        // 6. Récupère tous les statuts disponibles pour les filtres
        $statuses = Status::orderBy('order')->orderBy('name')->get();

        // 5. Récupère les résultats avec pagination (15 par page)
        // Tri par date d'échéance pour les agents renouvellement, sinon par dernière mise à jour
        if ($user->isAgentConseilRenouvellement()) {
            $opportunities = $query->orderBy('opportunities.echeance', 'asc')->paginate(15);
            return view('opportunities.renewals', compact('opportunities', 'statuses'));
        } else {
            $opportunities = $query->latest('opportunities.updated_at')->paginate(15);
              // 7. Affiche la vue avec les opportunités et statuts
            return view('opportunities.index', compact('opportunities', 'statuses'));
        }
    }

    public function listRenewals()
    {
        // 1. Récupère l'utilisateur connecté
        $user = auth()->user();

        // 2. Vérifier que c'est un Admin ou Lead
        if (!($user->isAdmin() || $user->isLead())) {
            abort(403, 'Accès non autorisé');
        }

        // 3. Récupérer toutes les opportunités qui ont au moins un contrat
        // Groupées par opportunity_id (au cas où plusieurs contrats par opportunité)
        $opportunities = Opportunity::whereHas('contracts')
            ->with(['status', 'client', 'creator', 'team', 'insurancePartner', 'comments', 'contracts'])
            ->latest()
            ->orderBy('opportunities.echeance', 'asc')
            ->paginate(20)
            ->withQueryString();

        // 4. Récupérer tous les statuts pour les filtres
        $statuses = Status::orderBy('order')->orderBy('name')->get();

        return view('opportunities.renewals', compact('opportunities', 'statuses', 'user'));
    }



    public function create()
    {
        $this->authorize('create', Opportunity::class);

        $statuses = Status::orderBy('order')->orderBy('name')->get();
        $insurancePartners = InsurancePartner::where('active', true)->orderBy('name')->get();

        return view('opportunities.create', compact('statuses', 'insurancePartners'));
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
        $insurancePartners = InsurancePartner::where('active', true)->orderBy('name')->get();

        return view('opportunities.edit', compact('opportunity', 'statuses', 'insurancePartners'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        //dd($request->all());
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenoms' => 'required|string|max:255',
                'telephone' => 'required|string|max:255',
                'telephone2' => 'nullable|string|max:255',
                'observation' => 'nullable|string',
                'canal' => 'nullable|string|max:255',
                'plaque_immatriculation' => 'nullable|string|max:255',
                'echeance' => 'nullable|date',
                'relance' => 'nullable|date',
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
                'status_id' => 'nullable|exists:statuses,id',
                'montant_nette_prime' => 'nullable|numeric',
                'contrat_assurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'duree_contrat' => 'nullable|string|max:255',
                'capture_paiement' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'body' => 'nullable|string',
            ]);

            // Gestion fichier carte grise back-office
            if ($request->hasFile('urlcarte_grise')) {
                $this->deleteFile($opportunity->urlcarte_grise);
                $validated['urlcarte_grise'] = $this->storeFile($request->file('urlcarte_grise'), 'documents/cartes_grises');
            } else {
                // Si pas de nouveau fichier, garder l'existant
                $validated['urlcarte_grise'] = $opportunity->urlcarte_grise;
            }

            // Gestion fichier attestation back-office
            if ($request->hasFile('url_attestationassurance')) {
                $this->deleteFile($opportunity->url_attestationassurance);
                $validated['url_attestationassurance'] = $this->storeFile($request->file('url_attestationassurance'), 'documents/attestations');
            } else {
                // Si pas de nouveau fichier, garder l'existant
                $validated['url_attestationassurance'] = $opportunity->url_attestationassurance;
            }

            // Gestion fichier capture paiement
            if ($request->hasFile('capture_paiement')) {
                if ($opportunity->capture_paiement) {
                    $this->deleteFile($opportunity->capture_paiement);
                }
                $validated['capture_paiement'] = $this->storeFile($request->file('capture_paiement'), 'documents/captures_paiement');
            } else {
                // Si pas de nouveau fichier, garder l'existant
                $validated['capture_paiement'] = $opportunity->capture_paiement ?? null;
            }

            // gerer le fichier contrat d'assurance
            if ($request->hasFile('contrat_assurance')) {
                if ($opportunity->contrat_assurance) {
                    $this->deleteFile($opportunity->contrat_assurance);
                }
                $validated['contrat_assurance'] = $this->storeFile($request->file('contrat_assurance'), 'documents/contrats_assurance');
            } else {
                // Si pas de nouveau fichier, garder l'existant
                $validated['contrat_assurance'] = $opportunity->contrat_assurance ?? null;
            }

            // Transaction de base de données - assure l'intégrité des données
            DB::beginTransaction();
           
            // creer le client automatiquement si le statut passe à gagné et qu'il n'existe pas déjà 
            if (isset($validated['status_id']) && $validated['status_id'] == 7) {
                $newStatus = Status::find($validated['status_id']);
                if ($newStatus->slug === 'gagne') {
                    // Créer le client SEULEMENT si l'opportunité n'a pas de client_id
                    if (!$opportunity->client_id) {
                        // Créer le client à partir des informations de l'opportunité
                        $client = Client::firstOrCreate(
                            [
                                'telephone' => $opportunity->telephone,
                            ],
                            [
                                'nom' => $opportunity->nom,
                                'prenoms' => $opportunity->prenoms,
                                'telephone2' => $opportunity->telephone2,
                            ]
                        );
                        
                        $validated['client_id'] = $client->id ;

                        Log::info('Client ID: ' . $client->id . ' créé automatiquement à partir de l\'opportunité ID: ' . $opportunity->id);
                    } else {
                        $validated['client_id'] = $opportunity->client_id ;
                        Log::info('Opportunité ID: ' . $opportunity->id . ' a déjà un client associé (ID: ' . $opportunity->client_id . ')');
                    }
                    $insurancePartner = InsurancePartner::where('name', $validated['assureur_actuel'])->first();
                    if ($insurancePartner) {
                        $contractData = [
                            'opportunity_id' => $opportunity->id,
                            'insurance_partner_id' => $insurancePartner->id,
                            'client_id' => $validated['client_id'],
                            'contract_number' => $this->generateContractNumber($opportunity->id),
                            'contract_start_date' => now()->format('Y-m-d'),
                            'contract_end_date' => now()->addYear()->format('Y-m-d'),
                            'contract_duration' => $validated['periode_souscription'] ?? null,
                            'net_premium' => $validated['montant_nette_prime'] ?? 0,
                            'ttc_premium' => $validated['montant_souscription'] ?? 0,
                            'commission_rate' => $insurancePartner->commission_rate ?? 0,
                            'commission_amount' => ($validated['montant_souscription'] ?? 0) * (($insurancePartner->commission_rate ?? 0) / 100),
                            'contract_document' => $validated['contrat_assurance'] ?? null,
                            'attestation_document' => $validated['url_attestationassurance'] ?? null,
                            'payment_proof' => $validated['capture_paiement'] ?? null,
                            'status' => 'active',
                            'observations' => 'Contrat créé automatiquement à partir de l\'opportunité #' . $opportunity->id,
                            'created_by' => $request->user()->id,
                        ];

                        // Créer le contrat directement sans passer par le ContractController
                        try {
                            Contract::create($contractData);
                            Log::info('Contrat créé automatiquement à partir de l\'opportunité ID: ' . $opportunity->id);
                        } catch (\Exception $e) {
                            Log::error('Erreur lors de la création automatique du contrat: ' . $e->getMessage());
                        }
                    }    
                    
                }
            } 

            // Mettre à jour l'opportunité
            $opportunity->update($validated);

            // Créer le commentaire s'il existe un champ "body" dans le formulaire (pour ajouter un commentaire lors de la mise à jour)
            $opportunity->comments()->create([
                'user_id' => $request->user()->id,
                'body' => $validated['body'],
            ]);

            DB::commit();
        
            Log::info('Opportunité ID: ' . $opportunity->id . ' mise à jour avec succès par l\'utilisateur ID: ' . $request->user()->id);

            return redirect()->route('opportunities.show', $opportunity)
                ->with('success', 'Opportunité mise à jour.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de l\'opportunité ID: ' . $opportunity->id . ' - ' . $e->getMessage());
            return redirect()->route('opportunities.edit', $opportunity)
                ->withInput($request->all())
                ->with('error', 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.');
        }
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
        try {
            $validated = $request->validate([
                'opportunity_ids' => 'required|string',
                'assigned_to' => 'required|exists:users,id',
                'date_affect' => 'required|date',
            ]);

            $ids = array_filter(explode(',', $validated['opportunity_ids']));

            if (empty($ids)) {
                return redirect()->route('opportunities.index')
                    ->with('error', 'Aucune opportunité sélectionnée.');
            }

            // Transaction de base de données - assure l'intégrité des données
            DB::transaction(function () use ($ids, $validated, $request) {
                Opportunity::whereIn('id', $ids)->update(['assigned_to' => $validated['assigned_to']]);

                // Créer les assignations pour chaque opportunité
                foreach ($ids as $opportunityId) {
                    // Mettre les assignations actives existantes à inactive
                    Assignment::where('opportunity_id', $opportunityId)
                        ->where('status', 'active')
                        ->update(['status' => 'inactive']);

                    // Créer la nouvelle assignation avec la date fournie
                    Assignment::create([
                        'opportunity_id' => $opportunityId,
                        'assigned_by' => $request->user()->id,
                        'assigned_to' => $validated['assigned_to'],
                        'status' => 'active',
                        'date_affect' => $validated['date_affect'],
                    ]);
                }
            });

            $count = count($ids);
            return redirect()->route('opportunities.index')
                ->with('success', $count . ' opportunité(s) affectée(s) avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affectation en masse: ' . $e->getMessage());
            return redirect()->route('opportunities.index')
                ->with('error', 'Une erreur est survenue lors de l\'affectation en masse. Veuillez réessayer.');

        }
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
