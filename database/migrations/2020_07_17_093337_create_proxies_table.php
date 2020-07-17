<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->string('ip', 100);
            $table->string('port', 5);
            $table->string('login', 45);
            $table->string('password', 45);
            $table->tinyInteger('status');
            $table->unsignedBigInteger('busy_by_task_id');
            $table->timestamp('last_used_on')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('is_banned');
            $table->timestamp('last_checked_on')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('last_checked_status', 100);
            $table->tinyInteger('check_state');
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
        Schema::dropIfExists('proxies');
    }
}
