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
    {Schema::create('animal_treatment', function (Blueprint $table) {
        $table->id();
        $table->string('type');
        $table->string('product');
        $table->string('application_method');
        $table->integer('days_until_withdrawal');
        $table->string('technician');
        $table->integer('dosage');
        $table->date('treatment_date');
        $table->string('body_part');
        $table->date('booster_date')->nullable();
        $table->double('total_cost', 8, 2);
        $table->text('description')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->unsignedBigInteger('farm')->default(0);
        $table->unsignedBigInteger('animal_id');

        $table->foreign('animal_id')->references('id')->on('all_animals')->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('farm')->references('id')->on('farm_details')->onDelete('cascade')->onUpdate('cascade');
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
