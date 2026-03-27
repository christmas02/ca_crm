<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\Team;
use App\Models\Contract;
use App\Models\InsurancePartner;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BordereauTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Récupérer les rôles et statuts nécessaires
        $roleConseil = \App\Models\Role::where('slug', 'agent_conseil')->first();
        $roleConseilRenouvellement = \App\Models\Role::where('slug', 'agent_conseil_renouvellement')->first();
        $statusGagne = Status::where('slug', 'gagne')->first();
        $statusEnCours = Status::where('slug', 'en_cours')->first();
        $statusRenouvellement = Status::where('slug', 'renouvellement')->first();

        // Créer une équipe de test si elle n'existe pas
        $team = Team::firstOrCreate(
            ['name' => 'Équipe Test'],
            ['description' => 'Équipe de test pour bordereaux']
        );

        // Créer un partenaire d'assurance si nécessaire
        $insurancePartner = InsurancePartner::first() ?? InsurancePartner::create([
            'name' => 'Assureur Test',
            'contact_person' => 'Contact Test',
            'email' => 'assureur@test.com',
            'phone' => '0600000000',
        ]);

        // Créer 5 conseillers de test
        $conseillers = [];
        for ($i = 1; $i <= 5; $i++) {
            $role = $i % 2 == 0 ? $roleConseil : $roleConseilRenouvellement;
            
            $conseiller = User::firstOrCreate(
                ['identification' => 'conseil_test_' . $i],
                [
                    'name' => 'Conseiller Test ' . $i,
                    'password' => bcrypt('password'),
                    'role_id' => $role?->id,
                    'team_id' => $team->id,
                    'actif' => true,
                ]
            );
            $conseillers[] = $conseiller;
        }

        // Créer des opportunités de test pour chaque conseiller
        foreach ($conseillers as $conseiller) {
            // Opportunités du jour (5 par conseiller)
            for ($j = 0; $j < 5; $j++) {
                Opportunity::firstOrCreate(
                    ['title' => 'Opp Test Jour ' . $conseiller->id . '_' . $j],
                    [
                        'assigned_to' => $conseiller->id,
                        'created_by' => $conseiller->id,
                        'status_id' => $statusEnCours?->id,
                        'nom' => $faker->lastName,
                        'prenoms' => $faker->firstName,
                        'telephone' => $faker->phoneNumber,
                        'title' => 'Opportunité ' . $faker->word,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }

            // Opportunités gagnées ce mois (8-15 par conseiller) WITH CONTRACTS
            $nbGagnees = rand(8, 15);
            for ($j = 0; $j < $nbGagnees; $j++) {
                $opp = Opportunity::firstOrCreate(
                    ['title' => 'Opp Gagnée ' . $conseiller->id . '_' . $j],
                    [
                        'assigned_to' => $conseiller->id,
                        'created_by' => $conseiller->id,
                        'status_id' => $statusGagne?->id,
                        'client_id' => null, // Sera défini si nécessaire
                        'nom' => $faker->lastName,
                        'prenoms' => $faker->firstName,
                        'telephone' => $faker->phoneNumber,
                        'title' => 'Opportunité gagnée ' . $faker->word,
                        'created_at' => Carbon::now()->startOfMonth()->addDays(rand(0, 24)),
                        'updated_at' => Carbon::now()->startOfMonth()->addDays(rand(0, 24)),
                    ]
                );

                // Créer un contrat associé à cette opportunité gagnée
                Contract::firstOrCreate(
                    ['opportunity_id' => $opp->id],
                    [
                        'insurance_partner_id' => $insurancePartner->id,
                        'created_by' => $conseiller->id,
                        'contract_number' => 'CNT-' . $opp->id . '-' . rand(1000, 9999),
                        'contract_start_date' => Carbon::now()->startOfMonth(),
                        'contract_end_date' => Carbon::now()->startOfMonth()->addMonths(12),
                        'contract_duration' => 12,
                        'net_premium' => rand(100, 1000),
                        'ttc_premium' => rand(100, 1200),
                        'commission_amount' => rand(10, 100),
                        'commission_rate' => rand(5, 15),
                        'status' => 'active',
                    ]
                );
            }

            // Opportunités à renouvellement (3-8 par conseiller) WITH CONTRACTS
            $nbRenouvellement = rand(3, 8);
            for ($j = 0; $j < $nbRenouvellement; $j++) {
                $opp = Opportunity::firstOrCreate(
                    ['title' => 'Opp Renouvellement ' . $conseiller->id . '_' . $j],
                    [
                        'assigned_to' => $conseiller->id,
                        'created_by' => $conseiller->id,
                        'status_id' => $statusRenouvellement?->id,
                        'nom' => $faker->lastName,
                        'prenoms' => $faker->firstName,
                        'telephone' => $faker->phoneNumber,
                        'title' => 'Renouvellement ' . $faker->word,
                        'created_at' => Carbon::now()->startOfMonth()->addDays(rand(0, 24)),
                        'updated_at' => Carbon::now()->startOfMonth()->addDays(rand(0, 24)),
                    ]
                );

                // Créer un contrat associé (renouvellement = opportunité a eu un contrat avant)
                Contract::firstOrCreate(
                    ['opportunity_id' => $opp->id],
                    [
                        'insurance_partner_id' => $insurancePartner->id,
                        'created_by' => $conseiller->id,
                        'contract_number' => 'REN-' . $opp->id . '-' . rand(1000, 9999),
                        'contract_start_date' => Carbon::now()->startOfMonth(),
                        'contract_end_date' => Carbon::now()->startOfMonth()->addMonths(12),
                        'contract_duration' => 12,
                        'net_premium' => rand(100, 1000),
                        'ttc_premium' => rand(100, 1200),
                        'commission_amount' => rand(10, 100),
                        'commission_rate' => rand(5, 15),
                        'status' => 'active',
                    ]
                );
            }

            // Opportunités en cours (10-20 par conseiller)
            $nbEnCours = rand(10, 20);
            for ($j = 0; $j < $nbEnCours; $j++) {
                Opportunity::firstOrCreate(
                    ['title' => 'Opp En Cours ' . $conseiller->id . '_' . $j],
                    [
                        'assigned_to' => $conseiller->id,
                        'created_by' => $conseiller->id,
                        'status_id' => $statusEnCours?->id,
                        'nom' => $faker->lastName,
                        'prenoms' => $faker->firstName,
                        'telephone' => $faker->phoneNumber,
                        'title' => 'Opportunité en cours ' . $faker->word,
                        'created_at' => Carbon::now()->startOfMonth()->addDays(rand(0, 24)),
                        'updated_at' => Carbon::now()->startOfMonth()->addDays(rand(0, 24)),
                    ]
                );
            }
        }

        $this->command->info('✅ Données de test créées avec succès pour les bordereaux!');
        $this->command->info('   - ' . count($conseillers) . ' conseillers créés');
        $this->command->info('   - Opportunités gagnées et renouvellement avec contrats créés');
    }
}
