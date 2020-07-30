<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSmsMmsMessagesAddMmsMediaFilesGroupsIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_mms_messages', function (Blueprint $table) {
            $table->unsignedInteger('mms_media_files_groups_id')->default(0)->after('advertising_campaign_task_id')->index('mms_media_files_groups_id');
            $table->index('advertising_campaign_task_id');
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
            $table->dropColumn('mms_media_files_groups_id');
            $table->dropIndex('advertising_campaign_task_id');
        });
    }
}
