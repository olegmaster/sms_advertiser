<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRenameAdvertisingCampaignsTasksIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_mms_messages', function (Blueprint $table) {
            $table->renameColumn('advertising_campaigns_tasks_id', 'advertising_campaign_tasks_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_mms_messages', function (Blueprint $table) {
            $table->renameColumn('advertising_campaign_tasks_id', 'advertising_campaigns_tasks_id');
        });
    }
}
