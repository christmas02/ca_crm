<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'website',
        'description',
        'logo',
        'commission_rate',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'commission_rate' => 'decimal:2',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
