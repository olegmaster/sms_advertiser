<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimcardOffersStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simcard_offers_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->integer('minute');
            $table->tinyInteger('hour');
            $table->tinyInteger('day');
            $table->tinyInteger('week');
            $table->tinyInteger('month');
            $table->integer('year');
            $table->integer('used_simcards_count');
            $table->integer('parsed_offers_count');
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
        Schema::dropIfExists('simcard_offers_stats');
    }
}
