<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->boolean('is_banned')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->boolean('is_frozen')->default(0);
            $table->timestamp('frozen_on')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('freeze_hours')->default(20);
            $table->integer('spam_limit')->default(20000);
            $table->integer('current_send_count')->default(0);
            $table->integer('all_send_count')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('domains');
    }
}
