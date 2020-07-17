<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxyToAdvertisingCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxy_to_advertising_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proxy_id');
            $table->unsignedBigInteger('advertising_campaign_task_id');

            $table->foreign('proxy_id')->references('id')->on('proxies');
            $table->foreign('advertising_campaign_task_id', 'proxy_to_advertising_campaigns_ac_task_id_foreign')->references('id')->on('advertising_campaign_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proxy_to_advertising_campaigns');
    }
}
