<?php

namespace Database\Seeders;

use App\Models\InsurancePartner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurancePartnerSeeder extends Seeder
{
    public function run()
    {
        $partners = [
            [
                'name' => 'Allianz Sénégal',
                'email' => 'contact@allianz-senegal.sn',
                'telephone' => '+221 33 849 9999',
                'website' => 'https://www.allianz.sn',
                'description' => 'Leader du marché de l\'assurance automobile au Sénégal',
                'commission_rate' => 10.5,
                'active' => true,
            ],
            [
                'name' => 'WARI',
                'email' => 'info@wari-assurance.sn',
                'telephone' => '+221 33 889 7777',
                'website' => 'https://wari-assurance.sn',
                'description' => 'Assurance automobile et multirisque habitation',
                'commission_rate' => 12.0,
                'active' => true,
            ],
            [
                'name' => 'CIMA Sénégal',
                'email' => 'contact@cima-senegal.sn',
                'telephone' => '+221 33 849 1111',
                'website' => 'https://cima-senegal.sn',
                'description' => 'Compagnie d\'assurance générale et automobile',
                'commission_rate' => 11.0,
                'active' => true,
            ],
            [
                'name' => 'Sénégal Assurances',
                'email' => 'support@senegal-assurances.sn',
                'telephone' => '+221 33 823 3030',
                'website' => 'https://senegal-assurances.sn',
                'description' => 'Assureur multibranche avec expertise automobile',
                'commission_rate' => 9.5,
                'active' => true,
            ],
            [
                'name' => 'Activa Assurances',
                'email' => 'info@activa-assurances.sn',
                'telephone' => '+221 33 842 5555',
                'website' => 'https://activa-assurances.sn',
                'description' => 'Assurance automobile performante et innovante',
                'commission_rate' => 10.0,
                'active' => true,
            ],
        ];

        foreach ($partners as $partner) {
            InsurancePartner::create($partner);
        }
    }
}

