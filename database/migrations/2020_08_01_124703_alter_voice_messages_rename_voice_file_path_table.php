<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVoiceMessagesRenameVoiceFilePathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voice_messages', function (Blueprint $table) {
            $table->renameColumn('voice_file_path', 'file_path');
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
            $table->renameColumn('file_path', 'voice_file_path');
        });
    }
}
