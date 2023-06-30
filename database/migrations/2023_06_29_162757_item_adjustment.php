<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('item_adjustment', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->string('adjustment_type', 50)->default('');
            $table->double('initial_value')->default(0);
            $table->double('adjusted_value')->default(0);
            $table->string('reason', 500)->default('');
            $table->string('account', 100)->default('');
            $table->string('description', 500)->nullable();
            $table->string('adjusted_by', 100)->default('');
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->integer('farm')->default(0);
            $table->timestamps();
        });

        Schema::table('item_adjustment', function (Blueprint $table) {
            $table->index('item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_adjustment');
    }
};
