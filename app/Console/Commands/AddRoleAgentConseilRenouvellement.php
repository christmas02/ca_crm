<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;

class AddRoleAgentConseilRenouvellement extends Command
{
    protected $signature = 'roles:add-agent-conseil-renouvellement';
    protected $description = 'Ajoute le rôle Agent Conseil Renouvellement';

    public function handle()
    {
        $exists = Role::where('slug', 'agent_conseil_renouvellement')->first();
        
        if ($exists) {
            $this->warn('❌ Le rôle Agent Conseil Renouvellement existe déjà');
            return;
        }

        Role::create([
            'name' => 'Agent Conseil Renouvellement',
            'slug' => 'agent_conseil_renouvellement',
        ]);

        $this->info('✅ Rôle Agent Conseil Renouvellement créé avec succès!');
        $this->line('Slug: agent_conseil_renouvellement');
    }
}
