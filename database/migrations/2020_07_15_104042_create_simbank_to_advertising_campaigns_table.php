<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimbankToAdvertisingCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simbank_to_advertising_campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('simbank_id');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->timestamps();

            $table->foreign('simbank_id')->references('id')->on('simbanks');
            $table->foreign('advertising_campaign_task_id', 'simbank_to_ac_ac_task_id_foreign')->references('id')->on('advertising_campaign_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simbank_to_advertising_campaigns');
    }
}
