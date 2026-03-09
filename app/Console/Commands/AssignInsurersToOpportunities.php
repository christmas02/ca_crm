<?php

namespace App\Console\Commands;

use App\Models\Opportunity;
use App\Models\InsurancePartner;
use Illuminate\Console\Command;

class AssignInsurersToOpportunities extends Command
{
    protected $signature = 'opportunities:assign-insurers {--ids=26,28,29}';
    protected $description = 'Assigne un assureur par défaut aux opportunités';

    public function handle()
    {
        $idsString = $this->option('ids');
        $ids = array_map('trim', explode(',', $idsString));

        $this->info("Assureurs actifs disponibles:");
        
        $insurers = InsurancePartner::where('active', true)
            ->select('id', 'name')
            ->get();
        
        foreach ($insurers as $insurer) {
            $this->line("  - {$insurer->id}: {$insurer->name}");
        }

        // Sélectionner le premier assureur
        $defaultInsurer = $insurers->first();
        
        if (!$defaultInsurer) {
            $this->error("Aucun assureur actif trouvé!");
            return;
        }

        $this->info("\nUtilisation de l'assureur par défaut: {$defaultInsurer->name}");

        // Mettre à jour les opportunités
        foreach ($ids as $id) {
            try {
                $opportunity = Opportunity::findOrFail($id);
                
                if ($opportunity->assureur_actuel) {
                    $this->line("  ⏭️  Opportunité {$id}: Assureur déjà assigné ({$opportunity->assureur_actuel})");
                    continue;
                }

                $opportunity->update(['assureur_actuel' => $defaultInsurer->name]);
                $this->line("  ✅ Opportunité {$id}: Assureur assigné à '{$defaultInsurer->name}'");
                
            } catch (\Exception $e) {
                $this->error("  ❌ Opportunité {$id}: Erreur - " . $e->getMessage());
            }
        }

        $this->info("\n✅ Mis à jour!");
    }
}
