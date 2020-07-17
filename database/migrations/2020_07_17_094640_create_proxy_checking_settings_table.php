<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxyCheckingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxy_checking_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('threads_count');
            $table->tinyInteger('check_try_count_in_thread');
            $table->tinyInteger('next_check_interval_in_thread');
            $table->integer('connect_timeout');
            $table->integer('content_timeout');
            $table->tinyInteger('check_on_add');
            $table->tinyInteger('schedule_check');
            $table->string('check_scheduled_on', 10);
            $table->tinyInteger('schedule_check_type');
            $table->timestamp('last_check_scheduled_on');
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
        Schema::dropIfExists('proxy_checking_settings');
    }
}
