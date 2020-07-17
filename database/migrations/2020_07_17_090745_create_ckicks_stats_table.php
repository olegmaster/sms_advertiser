<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCkicksStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ckicks_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->tinyInteger('sms_type');
            $table->tinyInteger('is_mms');
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('os_type_id');
            $table->bigInteger('phone');
            $table->string('ip');
            $table->timestamps();

            $table->foreign('os_type_id')->references('id')->on('os_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ckicks_stats');
    }
}
