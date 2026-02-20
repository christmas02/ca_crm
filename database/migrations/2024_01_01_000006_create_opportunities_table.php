<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            // Relations
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();

            // Infos prospect (directement dans l'opportunité)
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('telephone')->nullable();
            $table->string('telephone2')->nullable();

            // Infos de base
            $table->string('title')->nullable();
            $table->text('observation')->nullable();
            $table->string('canal')->nullable();
            $table->string('source')->nullable();

            // Véhicule
            $table->string('plaque_immatriculation')->nullable();
            $table->datetime('echeance')->nullable();
            $table->string('lieuprospection')->nullable();

            // Assurance
            $table->string('assureur_actuel')->nullable();
            $table->integer('periode_souscription')->nullable();
            $table->integer('montant_souscription')->nullable();
            $table->string('isasap')->nullable();

            // Documents terrain
            $table->string('urlcarte_grise_terrain')->nullable();
            $table->string('url_attestationassurance_terrain')->nullable();

            // Documents back-office
            $table->string('urlcarte_grise')->nullable();
            $table->string('url_attestationassurance')->nullable();

            // Statuts documents / discours
            $table->string('statut_discours')->nullable();
            $table->string('statut_carte_grise')->nullable();
            $table->string('statut_attestation')->nullable();

            // Doublon
            $table->integer('author_doublon_check')->nullable();
            $table->boolean('doublon_check')->default(false);
            $table->datetime('date_auth_doublon')->nullable();

            // Visibilité
            $table->integer('isvisible')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opportunities');
    }
};
