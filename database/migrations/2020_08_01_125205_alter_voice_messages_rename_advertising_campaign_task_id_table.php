<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVoiceMessagesRenameAdvertisingCampaignTaskIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voice_messages', function (Blueprint $table) {
            $table->renameColumn('advertising_campaign_task_id', 'advertising_campaigns_tasks_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voice_messages', function (Blueprint $table) {
            $table->renameColumn('advertising_campaigns_tasks_id', 'advertising_campaign_task_id');
        });
    }
}
