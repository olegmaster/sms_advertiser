<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simbanks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity')->default(0);
            $table->integer('all_sent_sms_count')->default(0);
            $table->integer('all_sent_mms_count')->default(0);
            $table->integer('all_sent_voice_call_count')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('countries_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simbanks');
    }
}
