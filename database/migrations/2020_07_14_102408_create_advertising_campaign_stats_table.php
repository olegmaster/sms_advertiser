<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingCampaignStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_campaign_stats', function (Blueprint $table) {
            $table->id();
            $table->integer('used_domains_count');
            $table->integer('used_simcards_count');
            $table->integer('used_proxies_count');
            $table->integer('all_sent_sms_count');
            $table->integer('avg_sent_sms_count');
            $table->integer('sms_text_variants_count');
            $table->integer('unique_sms_clicks_count');
            $table->integer('repeated_sms_clicks_count');
            $table->integer('all_sent_mms_count');
            $table->integer('avg_sent_mms_count');
            $table->integer('mms_text_variants_count');
            $table->integer('mms_media_variants_count');
            $table->integer('unique_mms_clicks_count');
            $table->integer('repeated_mms_clicks_count');
            $table->integer('all_voice_call_count');
            $table->integer('all_voice_call_heard');
            $table->integer('avg_voice_call_count');
            $table->integer('autosent_sms_mms_count');
            $table->integer('voice_media_variants_count');
            $table->integer('voice_unique_clicks_count');
            $table->integer('voice_repeated_clicks_count');
            $table->integer('voice_spam_count');
            $table->integer('autoanswer_sms_sent_count');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->timestamps();

            $table->foreign('advertising_campaign_task_id')->references('id')->on('advertising_campaign_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertising_campaign_stats');
    }
}
