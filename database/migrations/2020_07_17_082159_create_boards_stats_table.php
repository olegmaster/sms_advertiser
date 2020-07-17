<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_id');
            $table->timestamp('date');
            $table->integer('minute');
            $table->tinyInteger('hour');
            $table->tinyInteger('day');
            $table->tinyInteger('week');
            $table->tinyInteger('month');
            $table->integer('year');
            $table->integer('count');
            $table->timestamps();

            $table->foreign('board_id')->references('id')->on('boards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards_stats');
    }
}
