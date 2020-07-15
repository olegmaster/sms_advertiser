<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simcards', function (Blueprint $table) {
            $table->id();
            $table->string('number', 16);
            $table->tinyInteger('status');
            $table->tinyInteger('is_registered');
            $table->unsignedBigInteger('simcard_group_id');
            $table->unsignedBigInteger('simcard_operator_id');
            $table->timestamps();

            $table->foreign('simcard_group_id')->references('id')->on('simcard_groups');
            $table->foreign('simcard_operator_id')->references('id')->on('simcard_operators');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simcards');
    }
}
