<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'Nouvelle', 'group' => 'Nouvelle', 'slug' => 'nouvelle', 'order' => 1, 'color' => '#fbbf24'],
            ['name' => 'Rendez-vous souscription', 'group' => 'Rendez-vous', 'slug' => 'rendez_vous', 'order' => 2, 'color' => '#3b82f6'],
            ['name' => 'Poursuivre – Cotation envoyée', 'group' => 'Poursuivre', 'slug' => 'poursuivre', 'order' => 3, 'color' => '#3b82f6'],
            ['name' => 'Poursuivre – En attente de carte grise', 'group' => 'Poursuivre', 'slug' => 'poursuivre', 'order' => 3, 'color' => '#3b82f6'],
            ['name' => 'Poursuivre – Relance ferme', 'group' => 'Poursuivre', 'slug' => 'poursuivre', 'order' => 3, 'color' => '#3b82f6'],
            ['name' => 'Poursuivre – Véhicule au garage', 'group' => 'Poursuivre', 'slug' => 'poursuivre', 'order' => 3, 'color' => '#3b82f6'],
            ['name' => 'Client gagné', 'group' => 'Gagné', 'slug' => 'gagne', 'order' => 4, 'color' => '#10b981'],
            ['name' => 'Client perdu – Pas le propriétaire', 'group' => 'Perdus', 'slug' => 'perdus', 'order' => 5, 'color' => '#ef4444'],
            ['name' => 'Client perdu – Véhicule vendu', 'group' => 'Perdus', 'slug' => 'perdus', 'order' => 5, 'color' => '#ef4444'],
            ['name' => 'Client perdu – Prix trop élevé', 'group' => 'Perdus', 'slug' => 'perdus', 'order' => 5, 'color' => '#ef4444'],
            ['name' => 'Client perdu – Non joignable définitif', 'group' => 'Perdus', 'slug' => 'perdus', 'order' => 5, 'color' => '#ef4444'],
            ['name' => 'Client perdu – A déjà un assureur', 'group' => 'Perdus', 'slug' => 'perdus', 'order' => 5, 'color' => '#ef4444'],
            ['name' => 'Reporté – Ne décroche pas', 'group' => 'Reporter', 'slug' => 'reporter', 'order' => 6, 'color' => '#f59e0b'],
            ['name' => 'Reporté – En déplacement', 'group' => 'Reporter', 'slug' => 'reporter', 'order' => 6, 'color' => '#f59e0b'],
            ['name' => 'Reporté – Ligne indisponible', 'group' => 'Reporter', 'slug' => 'reporter', 'order' => 6, 'color' => '#f59e0b'],
            ['name' => 'Reporté – véhicule au garage ', 'group' => 'Reporter', 'slug' => 'reporter', 'order' => 6, 'color' => '#f59e0b'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
