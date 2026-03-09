<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAgentConseilRenouvellementUser extends Command
{
    protected $signature = 'users:create-agent-renouvellement {name=Agent Renouvellement} {identification=AGENT_RENEW}';
    protected $description = 'Crée un utilisateur Agent Conseil Renouvellement';

    public function handle()
    {
        $name = $this->argument('name');
        $identification = $this->argument('identification');

        // Récupérer le rôle
        $role = Role::where('slug', 'agent_conseil_renouvellement')->first();
        if (!$role) {
            $this->error('❌ Rôle agent_conseil_renouvellement non trouvé!');
            return;
        }

        // Récupérer une équipe par défaut
        $team = Team::first();
        if (!$team) {
            $this->error('❌ Aucune équipe trouvée!');
            return;
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $name,
            'identification' => $identification,
            'password' => Hash::make('password123'), // Mot de passe par défaut
            'role_id' => $role->id,
            'team_id' => $team->id,
        ]);

        $this->info('✅ Utilisateur créé avec succès!');
        $this->line("Nom: {$user->name}");
        $this->line("Identification: {$user->identification}");
        $this->line("Rôle: {$role->name}");
        $this->line("Équipe: {$team->name}");
        $this->warn("Mot de passe: password123");
    }
}
