<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Opportunity;
use App\Models\InsurancePartner;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ContractController extends Controller
{
    /**
     * Méthode de traitement des fichiers
     */
    private function storeFile($file, $folder)
    {
        try {
            if (!$file || !$file->isValid()) {
                Log::warning('Fichier invalide');
                return null;
            }

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

    /**
     * Affiche la liste de tous les contrats
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Contract::class);

        $query = Contract::with(['opportunity', 'insurancePartner', 'client', 'creator']);

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrer par partenaire d'assurance
        if ($request->filled('insurance_partner_id')) {
            $query->where('insurance_partner_id', $request->insurance_partner_id);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contract_number', 'like', "%{$search}%")
                  ->orWhereHas('client', fn($q) => $q->where('nom', 'like', "%{$search}%"))
                  ->orWhereHas('insurancePartner', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $contracts = $query->latest()->paginate(15);
        $insurancePartners = InsurancePartner::where('active', true)->orderBy('name')->get();
        $statuses = ['active' => 'Actif', 'inactive' => 'Inactif', 'terminated' => 'Résilié', 'renewed' => 'Renouvelé'];

        return view('contracts.index', compact('contracts', 'insurancePartners', 'statuses'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create(Request $request)
    {
        $this->authorize('create', Contract::class);

        $opportunityId = $request->query('opportunity_id');
        $opportunity = $opportunityId ? Opportunity::findOrFail($opportunityId) : null;

        $insurancePartners = InsurancePartner::where('active', true)->orderBy('name')->get();
        $clients = Client::orderBy('nom')->get();

        return view('contracts.create', compact('opportunity', 'insurancePartners', 'clients'));
    }

    /**
     * Enregistre un nouveau contrat
     */
    public function store(Request $request)
    {
        $this->authorize('create', Contract::class);

        try {
            $validated = $request->validate([
                'opportunity_id' => 'required|exists:opportunities,id',
                'insurance_partner_id' => 'required|exists:insurance_partners,id',
                'client_id' => 'nullable|exists:clients,id',
                'contract_number' => 'required|string|max:255|unique:contracts',
                'contract_start_date' => 'required|date',
                'contract_end_date' => 'nullable|date|after:contract_start_date',
                'contract_duration' => 'nullable|integer|min:1|max:120',
                'net_premium' => 'nullable|numeric|min:0',
                'ttc_premium' => 'nullable|numeric|min:0',
                'commission_amount' => 'nullable|numeric|min:0',
                'commission_rate' => 'nullable|numeric|min:0|max:100',
                'contract_document' => 'nullable|string',
                'attestation_document' => 'nullable|string',
                'payment_proof' => 'nullable|string',
                'status' => 'required|in:active,inactive,terminated,renewed',
                'observations' => 'nullable|string',
            ]);

            // Récupérer l'opportunity pour créer le client s'il n'existe pas
            $opportunity = Opportunity::findOrFail($validated['opportunity_id']);
            
            if (!$validated['client_id'] && $opportunity->client_id) {
                $validated['client_id'] = $opportunity->client_id;
            }

            $validated['created_by'] = $request->user()->id;

            //

            Contract::create($validated);
            Log::info('Contrat créé avec succès par l\'utilisateur ID: ' . $request->user()->id);

            return redirect()->route('contracts.index')
                ->with('success', 'Contrat créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du contrat: ' . $e->getMessage());
            return redirect()->route('contracts.create')
                ->withInput($request->all())
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un contrat
     */
    public function show(Contract $contract)
    {
        $this->authorize('view', $contract);

        $contract->load(['opportunity', 'insurancePartner', 'client', 'creator']);

        return view('contracts.show', compact('contract'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Contract $contract)
    {
        $this->authorize('update', $contract);

        $insurancePartners = InsurancePartner::where('active', true)->orderBy('name')->get();
        $clients = Client::orderBy('nom')->get();

        return view('contracts.edit', compact('contract', 'insurancePartners', 'clients'));
    }

    /**
     * Met à jour un contrat
     */
    public function update(Request $request, Contract $contract)
    {
        $this->authorize('update', $contract);

        try {
            $validated = $request->validate([
                'insurance_partner_id' => 'required|exists:insurance_partners,id',
                'client_id' => 'nullable|exists:clients,id',
                'contract_number' => 'required|string|max:255|unique:contracts,contract_number,' . $contract->id,
                'contract_start_date' => 'required|date',
                'contract_end_date' => 'nullable|date|after:contract_start_date',
                'contract_duration' => 'nullable|integer|min:1|max:120',
                'net_premium' => 'nullable|numeric|min:0',
                'ttc_premium' => 'nullable|numeric|min:0',
                'commission_amount' => 'nullable|numeric|min:0',
                'commission_rate' => 'nullable|numeric|min:0|max:100',
                'contract_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'attestation_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'payment_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'status' => 'required|in:active,inactive,terminated,renewed',
                'observations' => 'nullable|string',
            ]);

            // Gérer les fichiers
            if ($request->hasFile('contract_document')) {
                $this->deleteFile($contract->contract_document);
                $validated['contract_document'] = $this->storeFile(
                    $request->file('contract_document'),
                    'documents/contracts'
                );
            }

            if ($request->hasFile('attestation_document')) {
                $this->deleteFile($contract->attestation_document);
                $validated['attestation_document'] = $this->storeFile(
                    $request->file('attestation_document'),
                    'documents/attestations'
                );
            }

            if ($request->hasFile('payment_proof')) {
                $this->deleteFile($contract->payment_proof);
                $validated['payment_proof'] = $this->storeFile(
                    $request->file('payment_proof'),
                    'documents/payment_proofs'
                );
            }

            $contract->update($validated);
            Log::info('Contrat ID: ' . $contract->id . ' mis à jour par l\'utilisateur ID: ' . $request->user()->id);

            return redirect()->route('contracts.show', $contract)
                ->with('success', 'Contrat mis à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du contrat: ' . $e->getMessage());
            return redirect()->route('contracts.edit', $contract)
                ->withInput($request->all())
                ->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Supprime un contrat
     */
    public function destroy(Contract $contract)
    {
        $this->authorize('delete', $contract);

        try {
            // Supprimer les fichiers associés
            $this->deleteFile($contract->contract_document);
            $this->deleteFile($contract->attestation_document);
            $this->deleteFile($contract->payment_proof);

            $contract->delete();
            Log::info('Contrat ID: ' . $contract->id . ' supprimé par l\'utilisateur ID: ' . auth()->id());

            return redirect()->route('contracts.index')
                ->with('success', 'Contrat supprimé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du contrat: ' . $e->getMessage());
            return redirect()->route('contracts.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Génère un contrat depuis une opportunité "Gagné"
     */
    public function createFromOpportunity(Opportunity $opportunity)
    {
        if ($opportunity->status->slug !== 'gagne') {
            return redirect()->back()
                ->with('error', 'Vous pouvez créer un contrat que si l\'opportunité est "Gagné".');
        }

        return redirect()->route('contracts.create', ['opportunity_id' => $opportunity->id])
            ->with('info', 'Créer un nouveau contrat pour cet opportunité.');
    }
}
