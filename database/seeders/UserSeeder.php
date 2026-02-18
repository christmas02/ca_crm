<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $leadRole = Role::where('slug', 'lead')->first();
        $conseilRole = Role::where('slug', 'agent_conseil')->first();
        $terrainRole = Role::where('slug', 'agent_terrain')->first();

        $teamAlpha = Team::where('name', 'Équipe Alpha')->first();
        $teamBeta = Team::where('name', 'Équipe Beta')->first();

        // Admin
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@ca-crm.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'team_id' => null,
        ]);

        // Leads
        User::create([
            'name' => 'Sophie Martin',
            'email' => 'lead1@ca-crm.com',
            'password' => Hash::make('password'),
            'role_id' => $leadRole->id,
            'team_id' => $teamAlpha->id,
        ]);
        User::create([
            'name' => 'Pierre Dubois',
            'email' => 'lead2@ca-crm.com',
            'password' => Hash::make('password'),
            'role_id' => $leadRole->id,
            'team_id' => $teamBeta->id,
        ]);

        // Agents Conseil
        $conseilNames = ['Marie Leroy', 'Jean Moreau', 'Claire Bernard', 'Thomas Petit', 'Julie Robert'];
        foreach ($conseilNames as $i => $name) {
            User::create([
                'name' => $name,
                'email' => 'conseil' . ($i + 1) . '@ca-crm.com',
                'password' => Hash::make('password'),
                'role_id' => $conseilRole->id,
                'team_id' => $i < 3 ? $teamAlpha->id : $teamBeta->id,
            ]);
        }

        // Agents Terrain
        $terrainNames = ['Luc Durand', 'Emma Simon', 'Hugo Laurent', 'Léa Michel', 'Nathan Garcia'];
        foreach ($terrainNames as $i => $name) {
            User::create([
                'name' => $name,
                'email' => 'terrain' . ($i + 1) . '@ca-crm.com',
                'password' => Hash::make('password'),
                'role_id' => $terrainRole->id,
                'team_id' => $i < 3 ? $teamAlpha->id : $teamBeta->id,
            ]);
        }
    }
}
