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
        Schema::create('note_opportunites', function (Blueprint $table) {
            $table->id();
            $table->integer('idopportunite');
            $table->integer('idagentbackoffice');
            $table->boolean('inthabitation')->default(0);
            $table->boolean('intflotteauto')->default(0);
            $table->boolean('intsante')->default(0);
            $table->boolean('intvoyage')->default(0);
            $table->boolean('intautre')->default(0);
            $table->dateTime('daterelance')->nullable();
            $table->timestamp('heure_relance', $precision = 0)->nullable();;
            $table->dateTime('echeance')->nullable();
            $table->string('etapes')->nullable();
            $table->string('resultat')->nullable();
            $table->string('interetclient')->nullable();
            $table->string('assureur_actuel')->nullable();
            $table->integer('periode_soucription')->nullable();
            $table->integer('primenet')->nullable();
            $table->integer('primettc')->nullable();
            $table->text('observation')->nullable();
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
        Schema::dropIfExists('note_opportunites');
    }
};
