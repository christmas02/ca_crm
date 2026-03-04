<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('opportunity_id')->constrained('opportunities')->cascadeOnDelete();
            $table->foreignId('insurance_partner_id')->constrained('insurance_partners')->restrictOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            
            // Informations du contrat
            $table->string('contract_number')->unique();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->integer('contract_duration')->nullable(); // Durée en mois
            
            // Primes
            $table->decimal('net_premium', 10, 2)->nullable();
            $table->decimal('ttc_premium', 10, 2)->nullable();
            $table->decimal('commission_amount', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable(); // Taux en %
            
            // Documents
            $table->string('contract_document')->nullable();
            $table->string('attestation_document')->nullable();
            $table->string('payment_proof')->nullable();
            
            // Statut
            $table->enum('status', ['active', 'inactive', 'terminated', 'renewed'])->default('active');
            $table->text('observations')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
