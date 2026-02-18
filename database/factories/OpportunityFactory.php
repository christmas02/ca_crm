<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Opportunity;
use App\Models\Status;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpportunityFactory extends Factory
{
    protected $model = Opportunity::class;

    public function definition()
    {
        $sources = ['Téléphone', 'Email', 'Site web', 'Recommandation', 'Salon', 'Porte-à-porte'];

        return [
            'client_id' => Client::factory(),
            'created_by' => User::factory(),
            'assigned_to' => null,
            'status_id' => Status::inRandomOrder()->first()?->id ?? 1,
            'team_id' => Team::inRandomOrder()->first()?->id,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'source' => $this->faker->randomElement($sources),
        ];
    }
}
