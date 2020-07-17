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
            $table->bigInteger('number');
            $table->tinyInteger('status');
            $table->timestamp('tarif_end_time')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));;
            $table->tinyInteger('is_registered');
            $table->timestamp('register_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));;
            $table->double('balance');
            $table->boolean('is_used_on_spam');
            $table->timestamp('last_used')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('is_banned');
            $table->unsignedBigInteger('simcard_group_id');
            $table->unsignedBigInteger('simcard_operator_id');
            $table->unsignedBigInteger('simbank_id');
            $table->timestamps();

            $table->foreign('simcard_group_id')->references('id')->on('simcard_groups');
            $table->foreign('simcard_operator_id')->references('id')->on('simcard_operators');
            $table->foreign('simbank_id')->references('id')->on('simbanks');
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
