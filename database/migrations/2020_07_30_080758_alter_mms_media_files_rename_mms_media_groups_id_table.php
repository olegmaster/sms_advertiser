<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMmsMediaFilesRenameMmsMediaGroupsIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mms_media_files', function (Blueprint $table) {
            $table->renameColumn('mms_media_groups_id', 'mms_media_files_groups_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mms_media_files', function (Blueprint $table) {
            $table->renameColumn('mms_media_files_groups_id', 'mms_media_groups_id');
        });
    }
}
