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
            $table->string('url_preuve_paiement')->nullable();
            $table->string('url_avenant')->nullable();
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
            $table->dropColumn('url_preuve_paiement');
            $table->dropColumn('url_avenant');
        });
    }
};
