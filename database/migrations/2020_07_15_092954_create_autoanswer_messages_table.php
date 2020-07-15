<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoanswerMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autoanswer_messages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->unsignedBigInteger('message_id');
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
        Schema::dropIfExists('autoanswer_messages');
    }
}
