<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('our_phone');
            $table->unsignedBigInteger('phone');
            $table->tinyInteger('job_done');
            $table->unsignedBigInteger('job_done_by');
            $table->string('comment');
            $table->unsignedBigInteger('comment_by');
            $table->string('type');
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
        Schema::dropIfExists('incoming_calls');
    }
}
