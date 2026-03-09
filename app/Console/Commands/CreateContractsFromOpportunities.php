<?php

namespace App\Console\Commands;

use App\Models\Opportunity;
use App\Models\Status;
use App\Models\Client;
use App\Models\InsurancePartner;
use App\Models\Contract;
use App\Http\Controllers\ContractController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateContractsFromOpportunities extends Command
{
    protected $signature = 'contracts:create-from-opportunities {status_id=7}';
    protected $description = 'Crée automatiquement des contrats pour toutes les opportunités avec un statut spécifique';

    public function handle()
    {
        $statusId = $this->argument('status_id');
        
        $this->info("Récupération des opportunités avec le statut ID: {$statusId}...");

        // Récupérer toutes les opportunités avec le statut spécifié
        $opportunities = Opportunity::where('status_id', $statusId)
            ->with(['client', 'status'])
            ->get();

        if ($opportunities->isEmpty()) {
            $this->warn("Aucune opportunité trouvée avec le statut ID: {$statusId}");
            return;
        }

        $this->info("Traitement de " . $opportunities->count() . " opportunité(s)...");

        $created = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($opportunities as $opportunity) {
            try {
                // Vérifier si un contrat existe déjà
                $existingContract = Contract::where('opportunity_id', $opportunity->id)->first();
                if ($existingContract) {
                    $this->line("  ⏭️  Opportunité {$opportunity->id}: Contrat existe déjà (ID: {$existingContract->id})");
                    $skipped++;
                    continue;
                }

                // Créer le client s'il n'existe pas
                if (!$opportunity->client_id) {
                    $client = Client::firstOrCreate(
                        ['telephone' => $opportunity->telephone],
                        [
                            'nom' => $opportunity->nom,
                            'prenoms' => $opportunity->prenoms,
                            'telephone2' => $opportunity->telephone2,
                        ]
                    );
                    $opportunity->update(['client_id' => $client->id]);
                    $this->line("  ✅ Client créé pour l'opportunité {$opportunity->id}");
                }

                // Trouver l'assureur
                $insurancePartner = null;
                if ($opportunity->assureur_actuel) {
                    $insurancePartner = InsurancePartner::where('name', $opportunity->assureur_actuel)->first();
                }

                if (!$insurancePartner && $opportunity->insurance_partner_id) {
                    $insurancePartner = InsurancePartner::find($opportunity->insurance_partner_id);
                }

                if (!$insurancePartner) {
                    $this->line("  ⚠️  Opportunité {$opportunity->id}: Assureur non trouvé - SAUTÉ");
                    $skipped++;
                    continue;
                }

                // Préparer les données du contrat
                $contractData = [
                    'opportunity_id' => $opportunity->id,
                    'insurance_partner_id' => $insurancePartner->id,
                    'client_id' => $opportunity->client_id,
                    'contract_number' => $this->generateContractNumber($opportunity->id),
                    'contract_start_date' => now()->format('Y-m-d'),
                    'contract_end_date' => now()->addYear()->format('Y-m-d'),
                    'contract_duration' => $opportunity->contract_duration ?? null,
                    'net_premium' => $opportunity->montant_nette_prime ?? 0,
                    'ttc_premium' => $opportunity->montant_ttc ?? 0,
                    'commission_rate' => $insurancePartner->commission_rate ?? 0,
                    'commission_amount' => ($opportunity->montant_ttc ?? 0) * (($insurancePartner->commission_rate ?? 0) / 100),
                    'contract_document' => $opportunity->contrat_assurance ?? null,
                    'attestation_document' => $opportunity->url_attestationassurance ?? null,
                    'payment_proof' => $opportunity->capture_paiement ?? null,
                    'status' => 'active',
                    'observations' => 'Contrat créé automatiquement via commande CLI à partir de l\'opportunité #' . $opportunity->id,
                ];

                // Créer un Request simulé
                $contractRequest = Request::create('/contracts', 'POST', $contractData);
                
                // Créer un utilisateur par défaut (Admin)
                $admin = \App\Models\User::where('role_id', 1)->first();
                if ($admin) {
                    $contractRequest->setUserResolver(fn() => $admin);
                } else {
                    $this->warn("  ⚠️  Utilisateur Admin non trouvé - Impossible de créer le contrat");
                    $errors++;
                    continue;
                }

                // Appeler la méthode store du ContractController
                $contractController = new ContractController();
                $response = $contractController->store($contractRequest);

                Log::info('Contrat créé via CLI pour l\'opportunité ID: ' . $opportunity->id);
                $this->line("  ✅ Contrat créé pour l'opportunité {$opportunity->id}");
                $created++;

            } catch (\Exception $e) {
                Log::error('Erreur lors de la création de contrat (CLI) pour opportunité ' . $opportunity->id . ': ' . $e->getMessage());
                $this->error("  ❌ Erreur pour l'opportunité {$opportunity->id}: " . $e->getMessage());
                $errors++;
            }
        }

        // Résumé
        $this->info("\n========== RÉSUMÉ ==========");
        $this->info("✅ Contrats créés: {$created}");
        $this->warn("⏭️  Contrats déjà existants: {$skipped}");
        $this->error("❌ Erreurs: {$errors}");
        $this->info("===========================");
    }

    /**
     * Génère un numéro de contrat unique avec suffixe
     */
    private function generateContractNumber($opportunityId)
    {
        $existingContracts = Contract::where('opportunity_id', $opportunityId)->get();
        $count = $existingContracts->count();

        if ($count === 0) {
            return 'CTR-' . strtoupper(uniqid());
        }

        $lastContract = $existingContracts->last();
        $lastContractNumber = $lastContract->contract_number;

        $baseNumber = $lastContractNumber;
        if (preg_match('/-\d+$/', $lastContractNumber)) {
            $baseNumber = preg_replace('/-\d+$/', '', $lastContractNumber);
        }

        $newCount = $count + 1;
        
        if ($newCount === 1) {
            return $baseNumber;
        } elseif ($newCount === 2) {
            return $baseNumber . '-2';
        } else {
            return $baseNumber . '-' . $newCount;
        }
    }
}
