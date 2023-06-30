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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 100)->default('');
            $table->string('uom', 100)->default('');
            $table->string('item_group')->nullable();
            $table->string('item_category', 50)->default('');
            $table->double('item_price')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->integer('preferred_vendor')->nullable();
            $table->string('image', 500)->nullable();
            $table->tinyInteger('returnable')->nullable();
            $table->timestamp('create_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->integer('farm');
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->index('item_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
