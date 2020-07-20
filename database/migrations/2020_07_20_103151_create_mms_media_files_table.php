<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMmsMediaFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mms_media_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_path', 300);
            $table->unsignedBigInteger('mms_media_groups_id');
            $table->timestamps();

            $table->foreign('mms_media_groups_id')->references('id')->on('mms_media_files_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mms_media_files');
    }
}
