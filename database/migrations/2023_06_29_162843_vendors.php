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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name', 100)->default('');
            $table->string('company', 100)->default('');
            $table->string('phone', 100)->default('');
            $table->string('email', 100)->default('');
            $table->string('address', 100)->default('');
            $table->string('kra_pin', 100)->default('');
            $table->string('item_group', 100)->default('');
            $table->timestamp('reg_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->integer('farm')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
