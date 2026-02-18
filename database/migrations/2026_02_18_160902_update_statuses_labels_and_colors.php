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
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Delete existing statuses to replace with new ones
        \DB::statement('TRUNCATE TABLE statuses');
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Delete all statuses
        \DB::statement('TRUNCATE TABLE statuses');
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
