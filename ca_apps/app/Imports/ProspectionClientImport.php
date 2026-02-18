<?php

namespace App\Imports;

use App\Models\ProspectionClient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProspectionClientImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProspectionClient([
            //
            'created_at' =>\Carbon\Carbon::createFromFormat('d/m/Y', $row['date_creation'])->toDateString(),
            'nom' =>$row['nom'],
            'prenoms' =>$row['prenom'],
            'telephone' =>$row['telephone'],
            'echeance' =>\Carbon\Carbon::createFromFormat('d/m/Y', $row['echeance'])->toDateString(),
            'observation' =>$row['observation'],
        ]);
    }
}
