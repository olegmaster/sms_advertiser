<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardOtomotoFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_otomoto_filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('region_id');
            $table->integer('price_from');
            $table->integer('price_to');
            $table->integer('auto_type_id');
            $table->integer('auto_brand_id');
            $table->integer('year_from');
            $table->integer('year_to');
            $table->integer('mileage_from');
            $table->integer('mileage_to');
            $table->tinyInteger('offer_type');
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
        Schema::dropIfExists('board_otomoto_filters');
    }
}
