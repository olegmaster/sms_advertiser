<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Brokenice\LaravelMysqlPartition\Schema\Schema;

class CreateSpamLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spam_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('our_phone');
            $table->unsignedBigInteger('phone');
            $table->unsignedBigInteger('advertising_campaign_task_id');
            $table->unsignedBigInteger('thematics_id');
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->index(['our_phone', 'phone', 'advertising_campaign_task_id', 'thematics_id'], 'before_send');
            $table->index(['phone', 'our_phone', 'advertising_campaign_task_id', 'thematics_id'], 'incoming_call');
        });

        Schema::partitionByKey('spam_logs', 100);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spam_logs');
    }
}
