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
        Schema::table('prospection_clients', function (Blueprint $table) {
            //
             $table->integer('isvisible')->default(1)->nullable();
             $table->string('urlcarte_grise_terrain')->nullable();
             $table->string('url_attestationassurance_terrain')->nullable();
             $table->string('statut_discours')->nullable();
             $table->string('statut_carte_grise')->nullable();
             $table->string('statut_attestation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospection_clients', function (Blueprint $table) {
            //
            $table->dropColumn('isvisible');
            $table->dropColumn('urlcarte_grise_terrain');
            $table->dropColumn('url_attestationassurance_terrain');
            $table->dropColumn('statut_discours');
            $table->dropColumn('statut_carte_grise');
            $table->dropColumn('statut_attestation');
        });
    }
};
