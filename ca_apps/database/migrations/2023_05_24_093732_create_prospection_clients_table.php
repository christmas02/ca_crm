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
        Schema::create('prospection_clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('telephone')->nullable();
            $table->dateTime('echeance')->nullable();
            $table->string('lieuprospection')->nullable();
            $table->string('canal')->nullable();
            $table->string('statut')->nullable();
            $table->string('isasap')->nullable();
            $table->text('observation')->nullable();
            $table->string('urlcarte_grise')->nullable();
            $table->string('url_attestationassurance')->nullable();
            $table->string('assureur_actuel')->nullable();
            $table->integer('periode_soucription')->nullable();
            $table->integer('montant_soucription')->nullable();
            $table->integer('realiserpar')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospection_clients');
    }
};
