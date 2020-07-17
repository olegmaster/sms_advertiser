<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimgroupToAdvertisingCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simgroup_to_advertising_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('simcard_group_id');
            $table->unsignedBigInteger('advertising_campaign_task_id');

            $table->foreign('simcard_group_id')->references('id')->on('simcard_groups');
            $table->foreign('advertising_campaign_task_id', 'simgroup_to_ac_task_id_foreign')->references('id')->on('advertising_campaign_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simgroup_to_advertising_campaigns');
    }
}
