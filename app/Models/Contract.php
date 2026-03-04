<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'opportunity_id',
        'insurance_partner_id',
        'client_id',
        'created_by',
        'contract_number',
        'contract_start_date',
        'contract_end_date',
        'contract_duration',
        'net_premium',
        'ttc_premium',
        'commission_amount',
        'commission_rate',
        'contract_document',
        'attestation_document',
        'payment_proof',
        'status',
        'observations',
    ];

    protected $casts = [
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'net_premium' => 'decimal:2',
        'ttc_premium' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
    ];

    /**
     * Relations
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function insurancePartner()
    {
        return $this->belongsTo(InsurancePartner::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Accesseurs
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getCommissionFromNet()
    {
        if ($this->net_premium && $this->commission_rate) {
            return ($this->net_premium * $this->commission_rate) / 100;
        }
        return null;
    }
}
