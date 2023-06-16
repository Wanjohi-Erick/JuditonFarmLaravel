<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pigs', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('tag');
            $table->date('date_acquired');
            $table->string('breed');
            $table->float('weight');
            $table->date('date_last_weighed');
            $table->string('gender');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pigs');
    }
};
