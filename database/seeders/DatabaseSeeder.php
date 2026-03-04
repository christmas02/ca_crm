<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            StatusSeeder::class,
            TeamSeeder::class,
            UserSeeder::class,
            OpportunitySeeder::class,
            InsurancePartnerSeeder::class,
        ]);
    }
}
