<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpamLogDialogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spam_log_dialogs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('message_type');
            $table->tinyInteger('destination_type');
            $table->tinyInteger('message_sent_state');
            $table->string('message_sent_status');
            $table->timestamp('message_sent_at');
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('spam_log_id');
            $table->tinyInteger('is_new');
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
        Schema::dropIfExists('spam_log_dialogs');
    }
}
