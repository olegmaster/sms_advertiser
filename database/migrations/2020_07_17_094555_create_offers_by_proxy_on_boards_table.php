<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersByProxyOnBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_by_proxy_on_boards', function (Blueprint $table) {
            $table->id();
            $table->integer('offers_count');
            $table->unsignedBigInteger('proxy_id');
            $table->unsignedBigInteger('board_id');

            $table->foreign('proxy_id')->references('id')->on('proxies');
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
        Schema::dropIfExists('offers_by_proxy_on_boards');
    }
}
