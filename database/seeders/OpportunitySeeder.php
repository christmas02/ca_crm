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
        $terrainUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_terrain'))->get();
        $conseilUsers = User::whereHas('role', fn($q) => $q->where('slug', 'agent_conseil'))->get();
        $leads = User::whereHas('role', fn($q) => $q->where('slug', 'lead'))->get();
        $statuses = Status::orderBy('order')->get();

        $sources = ['Téléphone', 'Email', 'Site web', 'Recommandation', 'Salon', 'Porte-à-porte'];
        $canals = ['Appel téléphonique', 'Email direct', 'Porte-à-porte', 'Salon auto', 'Web', 'Recommandation'];
        $locations = ['Paris 15e', 'Lyon Presqu\'île', 'Marseille Centre', 'Bordeaux', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg'];
        $assureurs = ['AXA', 'Allianz', 'MAIF', 'MACIF', 'Groupama', 'MMA', 'Matmut', 'GMF'];
        $titles = [
            'Assurance Auto', 'Assurance Habitation', 'Assurance Vie',
            'Mutuelle Santé', 'Assurance Pro', 'Prévoyance',
            'Assurance Emprunteur', 'Garantie Accident',
        ];

        $firstNames = ['Amadou', 'Fatou', 'Moussa', 'Aïssatou', 'Ibrahima', 'Mariama', 'Ousmane', 'Adama', 'Djibril', 'Khadija',
                        'Sékou', 'Aminata', 'Mamadou', 'Fatoumata', 'Abdoulaye', 'Mariam', 'Boubacar', 'Rokia', 'Cheick', 'Hawa'];
        $lastNames = ['Diallo', 'Traoré', 'Konaté', 'Coulibaly', 'Touré', 'Keïta', 'Bamba', 'Sylla', 'Camara', 'Sanogo',
                      'Koné', 'Dembélé', 'Cissé', 'Diarra', 'Sissoko', 'Fofana', 'Doumbia', 'Samaké', 'Sidibé', 'Bagayoko'];

        for ($i = 0; $i < 30; $i++) {
            $creator = $terrainUsers->random();
            $status = $statuses->random();
            $assignee = null;

            if ($status->order > 1) {
                $assignee = $conseilUsers->random();
            }

            $opportunity = Opportunity::create([
                'created_by' => $creator->id,
                'assigned_to' => $assignee?->id,
                'status_id' => $status->id,
                'team_id' => $creator->team_id,
                'nom' => fake()->randomElement($lastNames),
                'prenoms' => fake()->randomElement($firstNames),
                'telephone' => fake()->numerify('+225 ## ## ## ## ##'),
                'telephone2' => fake()->boolean(40) ? fake()->numerify('+225 ## ## ## ## ##') : null,
                'title' => fake()->randomElement($titles) . ' - ' . fake()->randomElement($lastNames),
                'observation' => fake()->paragraph(),
                'source' => fake()->randomElement($sources),
                'canal' => fake()->randomElement($canals),
                'plaque_immatriculation' => strtoupper(fake()->bothify('??-###-??')),
                'echeance' => fake()->dateTimeBetween('+1 month', '+2 years'),
                'lieuprospection' => fake()->randomElement($locations),
                'assureur_actuel' => fake()->randomElement($assureurs),
                'periode_souscription' => fake()->randomElement([6, 12, 24, 36]),
                'montant_souscription' => fake()->numberBetween(200, 3000),
                'isasap' => fake()->randomElement(['oui', 'non', null]),
                'urlcarte_grise_terrain' => fake()->boolean(70) ? 'documents/carte-grise-terrain-' . $i . '.pdf' : null,
                'url_attestationassurance_terrain' => fake()->boolean(60) ? 'documents/attestation-terrain-' . $i . '.pdf' : null,
                'urlcarte_grise' => fake()->boolean(40) ? 'documents/carte-grise-' . $i . '.pdf' : null,
                'url_attestationassurance' => fake()->boolean(30) ? 'documents/attestation-' . $i . '.pdf' : null,
                'statut_discours' => fake()->randomElement(['Validé', 'En attente', 'Rejeté', null]),
                'statut_carte_grise' => fake()->randomElement(['Reçu', 'Manquant', 'En attente', null]),
                'statut_attestation' => fake()->randomElement(['Reçu', 'Manquant', 'En attente', null]),
                'doublon_check' => fake()->boolean(10),
                'isvisible' => 1,
            ]);

            // Si statut "Gagné", créer le client automatiquement
            if ($status->slug === 'gagne') {
                $client = Client::firstOrCreate(
                    ['telephone' => $opportunity->telephone],
                    [
                        'nom' => $opportunity->nom,
                        'prenoms' => $opportunity->prenoms,
                        'telephone2' => $opportunity->telephone2,
                        'plaque_immatriculation' => $opportunity->plaque_immatriculation,
                        'assureur_actuel' => $opportunity->assureur_actuel,
                        'lieuprospection' => $opportunity->lieuprospection,
                    ]
                );
                $opportunity->update(['client_id' => $client->id]);
            }

            if ($assignee) {
                Assignment::create([
                    'opportunity_id' => $opportunity->id,
                    'assigned_by' => $leads->random()->id,
                    'assigned_to' => $assignee->id,
                ]);
            }

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
