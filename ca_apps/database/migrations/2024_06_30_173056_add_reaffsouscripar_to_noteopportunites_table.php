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
        Schema::table('note_opportunites', function (Blueprint $table) {
            //
             $table->integer('souscrit_par')->nullable();
             $table->integer('reaff_par')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('note_opportunites', function (Blueprint $table) {
            //
             $table->dropColumn('souscrit_par');
              $table->dropColumn('reaff_par');
        });
    }
};
