<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('group');
            $table->integer('order')->default(0);
            $table->string('color')->default('#6b7280');
            $table->timestamps();

            $table->index('slug');
            $table->index('group');
        });
    }

    public function down()
    {
        Schema::dropIfExists('statuses');
    }
};
