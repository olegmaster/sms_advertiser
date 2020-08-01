<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSmsMmsMessagesAddIndexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_mms_messages', function (Blueprint $table) {
            $table->index(['message_type', 'destination_type'], 'message_type_destination_type_index');
            $table->index('text', 'text_index' );
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
            $table->dropIndex('message_type_destination_type_index');
            $table->dropIndex('text_index');
        });
    }
}
