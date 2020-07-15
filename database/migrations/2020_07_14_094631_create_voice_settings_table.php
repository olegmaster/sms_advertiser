<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('send_conditions');
            $table->tinyInteger('send_type');
            $table->string('sms_text');
            $table->string('add_link');
            $table->text('media_files');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->timestamps();

            $table->foreign('advertising_campaign_task_id')->references('id')->on('advertising_campaign_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voice_settings');
    }
}
