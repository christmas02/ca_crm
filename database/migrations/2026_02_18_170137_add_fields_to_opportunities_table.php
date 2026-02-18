<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->string('canal')->nullable()->comment('Moyen d\'arrivée de l\'opportunité (Téléphone, Email, etc)');
            $table->string('vehicle_registration')->nullable()->comment('Immatriculation du véhicule');
            $table->date('insurance_expiration_date')->nullable()->comment('Date d\'échéance de l\'assurance du véhicule');
            $table->string('prospection_location')->nullable()->comment('Lieu de prospection');
            $table->string('gray_card_path')->nullable()->comment('Chemin du fichier carte grise');
            $table->string('attestation_path')->nullable()->comment('Chemin du fichier attestation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn(['canal', 'vehicle_registration', 'insurance_expiration_date', 'prospection_location', 'gray_card_path', 'attestation_path']);
        });
    }
};
