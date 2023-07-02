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
        Schema::create('transactions', function (Blueprint $table) {
            $table -> id();
            $table->string('reference', 100);
            $table->string('type', 100);
            $table->string('description', 500)->default('');
            $table->string('individual', 100)->default('');
            $table->integer('bank')->default(0)->default(0);
            $table->string('account', 100)->default('');
            $table->double('amount', 8, 2)->default(0.00);
            $table->string('status', 100)->default('');
            $table->unsignedBigInteger('farm')->default(0);
            $table->foreign('farm')
                ->references('id')
                ->on('farm_details')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
