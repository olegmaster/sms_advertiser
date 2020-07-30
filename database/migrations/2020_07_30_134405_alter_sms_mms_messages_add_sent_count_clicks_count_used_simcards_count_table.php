<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSmsMmsMessagesAddSentCountClicksCountUsedSimcardsCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_mms_messages', function (Blueprint $table) {
            $table->unsignedInteger('sent_count')->default(0);
            $table->unsignedInteger('clicks_count')->default(0);
            $table->unsignedInteger('used_simcards_count')->default(0);
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
            $table->dropColumn('sent_count');
            $table->dropColumn('clicks_count');
            $table->dropColumn('used_simcards_count');
        });
    }
}
