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
             $table->integer('author_doublon_check')->nullable();
             $table->boolean('doublon_check')->default(false);
             $table->dateTime('date_auth_doublon')->nullable();
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
              $table->dropColumn(['author_doublon_check', 'doublon_check','date_auth_doublon']);
             
        });
    }
};
