<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run()
    {
        Team::create(['name' => 'Équipe Alpha', 'description' => 'Première équipe commerciale']);
        Team::create(['name' => 'Équipe Beta', 'description' => 'Deuxième équipe commerciale']);
    }
}
