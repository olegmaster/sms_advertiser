<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetingTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targeting_tasks', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('source_type');
            $table->string('source_file_name');
            $table->unsignedBigInteger('filter_id');
            $table->timestamp('pars_start_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('pars_finish_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('last_update_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('state');
            $table->string('stop_comment');
            $table->tinyInteger('type');
            $table->boolean('is_archive');
            $table->unsignedBigInteger('target_audience_id');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('board_olx_filter_id');
            $table->unsignedBigInteger('board_otomoto_filter_id');
            $table->softDeletes();
            $table->integer('dd');
            $table->timestamps();

            $table->foreign('target_audience_id')->references('id')->on('target_audiences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('targeting_tasks');
    }
}
