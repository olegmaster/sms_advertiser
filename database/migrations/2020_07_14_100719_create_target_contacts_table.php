<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('phone');
            $table->string('phone_str', 15);
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('target_audience_id');
            $table->timestamps();

            $table->foreign('board_id')->references('id')->on('target_audiences');
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
        Schema::dropIfExists('target_contacts');
    }
}
