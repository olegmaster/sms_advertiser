<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnsubscribedRecipientLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribed_recipient_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thematics_id');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->unsignedBigInteger('target_contact_id');
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
        Schema::dropIfExists('unsubscribed_recipient_logs');
    }
}
