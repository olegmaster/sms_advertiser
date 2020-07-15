<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardOlxFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_olx_filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('target_task_id');
            $table->text('key_words');
            $table->integer('price_from');
            $table->integer('price_to');
            $table->unsignedBigInteger('subcategory_id');
            $table->integer('location_distance');
            $table->boolean('is_ready_to_bargain');

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
        Schema::dropIfExists('board_olx_filters');
    }
}
