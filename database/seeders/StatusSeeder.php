<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'Nouveau', 'slug' => 'nouveau', 'order' => 1, 'color' => '#3b82f6'],
            ['name' => 'Affecté', 'slug' => 'affecte', 'order' => 2, 'color' => '#8b5cf6'],
            ['name' => 'En cours', 'slug' => 'en_cours', 'order' => 3, 'color' => '#f59e0b'],
            ['name' => 'Contacté', 'slug' => 'contacte', 'order' => 4, 'color' => '#06b6d4'],
            ['name' => 'Transformé', 'slug' => 'transforme', 'order' => 5, 'color' => '#10b981'],
            ['name' => 'Perdu', 'slug' => 'perdu', 'order' => 6, 'color' => '#ef4444'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
