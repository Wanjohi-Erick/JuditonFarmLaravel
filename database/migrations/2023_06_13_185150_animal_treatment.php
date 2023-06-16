<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animal_treatment', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('product');
            $table->string('application_method');
            $table->integer('days_until_withdrawal');
            $table->string('technician');
            $table->integer('dosage');
            $table->date('treatment_date');
            $table->string('body_part');
            $table->date('booster_date');
            $table->float('total_cost');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_treatment');
    }
};
