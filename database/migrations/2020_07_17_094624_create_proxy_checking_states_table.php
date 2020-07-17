<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxyCheckingStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxy_checking_states', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_banned');
            $table->tinyInteger('check_state');
            $table->timestamp('last_checked_on');
            $table->string('last_check_status', 100);

            $table->unsignedBigInteger('proxy_id');
            $table->unsignedBigInteger('board_id');
            $table->timestamps();

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
        Schema::dropIfExists('proxy_checking_states');
    }
}
