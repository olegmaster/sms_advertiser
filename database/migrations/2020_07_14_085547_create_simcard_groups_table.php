<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimcardGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simcard_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('all_clicks_count')->default(0);
            $table->integer('all_sent_sms_count')->default(0);
            $table->integer('all_sent_voice_call_count')->default(0);
            $table->boolean('is_used_on_spam')->default(0);
            $table->tinyInteger('status');
            $table->unsignedBigInteger('countries_id');
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
        Schema::dropIfExists('simcard_groups');
    }
}
