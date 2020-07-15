<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoiceMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_messages', function (Blueprint $table) {
            $table->id();
            $table->string('voice_file_path');
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
        Schema::dropIfExists('voice_messages');
    }
}
