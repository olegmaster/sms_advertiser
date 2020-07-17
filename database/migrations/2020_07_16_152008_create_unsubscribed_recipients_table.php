<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnsubscribedRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribed_recipients', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('add_type');
            $table->bigInteger('phone');
            $table->string('name');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->unsignedBigInteger('city_id');
            $table->timestamps();

            $table->foreign('advertising_campaign_task_id')->references('id')->on('advertising_campaign_tasks');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unsubscribed_recipients');
    }
}
