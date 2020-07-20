<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsMmsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_mms_messages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('message_type');
            $table->tinyInteger('destination_type');
            $table->string('text', 320);
            $table->string('add_link');
            $table->tinyInteger('include_name');
            $table->unsignedBigInteger('parent_id');
            $table->smallInteger('sort_order');
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
        Schema::dropIfExists('sms_mms_messages');
    }
}
