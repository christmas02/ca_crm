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
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opportunities');
    }
};
