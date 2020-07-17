<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('sms_send_speed_from');
            $table->tinyInteger('sms_send_speed_to');
            $table->tinyInteger('mms_send_speed_from');
            $table->tinyInteger('mms_send_speed_to');
            $table->tinyInteger('voice_call_send_speed_from');
            $table->tinyInteger('voice_call_send_speed_to');
            $table->tinyInteger('sms_send_priority');
            $table->tinyInteger('voice_call_send_priority');
            $table->tinyInteger('asterisk_is_available');
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
        Schema::dropIfExists('global_settings');
    }
}
