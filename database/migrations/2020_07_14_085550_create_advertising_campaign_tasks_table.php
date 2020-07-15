<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingCampaignTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_campaign_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', '95');
            $table->unsignedBigInteger('thematics_id');
            $table->tinyInteger('source_type');
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('simcard_group_id');
            $table->unsignedBigInteger('creator_user_id');
            $table->string('comment', 1000);
            $table->tinyInteger('state');
            $table->string('stop_comment');
            $table->tinyInteger('is_deleted');
            $table->tinyInteger('is_archived');
            $table->timestamp('start_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('finish_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('send_sms_mms');
            $table->boolean('send_voice');
            $table->boolean('auto_answer');
            $table->tinyInteger('send_sms_voice_priority');
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('thematics_id')->references('id')->on('thematics');
            $table->foreign('simcard_group_id')->references('id')->on('simcard_groups');
            $table->foreign('creator_user_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertising_campaign_tasks');
    }
}
