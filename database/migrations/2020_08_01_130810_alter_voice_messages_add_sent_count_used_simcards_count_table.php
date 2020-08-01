<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVoiceMessagesAddSentCountUsedSimcardsCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voice_messages', function (Blueprint $table) {
            $table->unsignedInteger('sent_count')->default(0);
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
        Schema::table('voice_messages', function (Blueprint $table) {
            $table->dropColumn('sent_count');
            $table->dropColumn('used_simcards_count');
        });
    }
}
