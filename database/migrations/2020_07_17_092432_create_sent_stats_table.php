<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->integer('minute');
            $table->tinyInteger('hour');
            $table->tinyInteger('day');
            $table->tinyInteger('week');
            $table->tinyInteger('month');
            $table->integer('year');
            $table->integer('sms_count');
            $table->integer('mms_count');
            $table->integer('voice_call_count');
            $table->unsignedBigInteger('advertising_campaign_task_id');
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
        Schema::dropIfExists('sent_stats');
    }
}
