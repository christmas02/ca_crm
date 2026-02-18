<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Client;
use App\Models\Comment;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    public function run()
    {
        $clients = Client::factory(50)->create();

        $terrainUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_terrain'))->get();
        $conseilUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_conseil'))->get();
        $leads = User::whereHas('role', fn($q) => $q->where('slug', 'lead'))->get();
        $statuses = Status::orderBy('order')->get();

        $sources = ['Téléphone', 'Email', 'Site web', 'Recommandation', 'Salon', 'Porte-à-porte'];
        $titles = [
            'Assurance Auto', 'Assurance Habitation', 'Assurance Vie',
            'Mutuelle Santé', 'Assurance Pro', 'Prévoyance',
            'Assurance Emprunteur', 'Garantie Accident',
        ];

        for ($i = 0; $i < 30; $i++) {
            $creator = $terrainUsers->random();
            $status = $statuses->random();
            $assignee = null;

            // Assign to conseil agent if status is beyond "Nouveau"
            if ($status->order > 1) {
                $assignee = $conseilUsers->random();
            }

            $opportunity = Opportunity::create([
                'client_id' => $clients->random()->id,
                'created_by' => $creator->id,
                'assigned_to' => $assignee?->id,
                'status_id' => $status->id,
                'team_id' => $creator->team_id,
                'title' => fake()->randomElement($titles) . ' - ' . fake()->company(),
                'description' => fake()->paragraph(),
                'source' => fake()->randomElement($sources),
            ]);

            // Add assignment history if assigned
            if ($assignee) {
                Assignment::create([
                    'opportunity_id' => $opportunity->id,
                    'assigned_by' => $leads->random()->id,
                    'assigned_to' => $assignee->id,
                ]);
            }

            // Add some comments
            $commentCount = rand(0, 3);
            for ($j = 0; $j < $commentCount; $j++) {
                Comment::create([
                    'opportunity_id' => $opportunity->id,
                    'user_id' => collect([$creator, $assignee])->filter()->random()->id,
                    'body' => fake()->sentence(),
                ]);
            }
        }
    }
}
