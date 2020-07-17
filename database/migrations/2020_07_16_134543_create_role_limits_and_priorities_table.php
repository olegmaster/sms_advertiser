<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleLimitsAndPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_limits_and_priorities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roles_id');
            $table->integer('parse_per_hour_from');
            $table->integer('parse_per_hour_to');
            $table->integer('sent_sms_per_hour_from');
            $table->integer('sent_sms_per_hour_to');
            $table->integer('sent_mms_per_hour_from');
            $table->integer('sent_mms_per_hour_to');
            $table->integer('voice_calls_per_hour_from');
            $table->integer('voice_calls_per_hour_to');
            $table->integer('active_advertising_campaigns_tasks');
            $table->integer('active_targeting_tasks');
            $table->integer('parsed_contacts_per_month');
            $table->integer('targeting_tasks_priority');
            $table->integer('advertising_campaigns_tasks_priority');
            $table->timestamps();

            $table->foreign('roles_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_limits_and_priorities');
    }
}
