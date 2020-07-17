<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingCampaignsSpeedStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_campaigns_speed_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->integer('minute');
            $table->tinyInteger('hour');
            $table->tinyInteger('day');
            $table->tinyInteger('week');
            $table->tinyInteger('month');
            $table->integer('year');
            $table->integer('count');

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
        Schema::dropIfExists('advertising_campaigns_speed_stats');
    }
}
