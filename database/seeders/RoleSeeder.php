<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Administrateur', 'slug' => 'admin'],
            ['name' => 'Lead', 'slug' => 'lead'],
            ['name' => 'Agent Conseil', 'slug' => 'agent_conseil'],
            ['name' => 'Agent Terrain', 'slug' => 'agent_terrain'],
            ['name' => 'Agent Conseil Renouvellement', 'slug' => 'agent_conseil_renouvellement'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
