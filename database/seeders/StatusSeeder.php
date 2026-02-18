<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'Nouvelle', 'slug' => 'nouvelle', 'order' => 1, 'color' => '#fbbf24'],
            ['name' => 'Rendez-vous', 'slug' => 'rendez_vous', 'order' => 2, 'color' => '#3b82f6'],
            ['name' => 'Poursuivre', 'slug' => 'poursuivre', 'order' => 3, 'color' => '#3b82f6'],
            ['name' => 'Gagné', 'slug' => 'gagne', 'order' => 4, 'color' => '#10b981'],
            ['name' => 'Perdus', 'slug' => 'perdus', 'order' => 5, 'color' => '#ef4444'],
            ['name' => 'Reporter', 'slug' => 'reporter', 'order' => 6, 'color' => '#f59e0b'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
