<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetAudiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_audiences', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->tinyInteger('source_type');
            $table->unsignedBigInteger('source_id');
            $table->string('source_file_name');
            $table->integer('contacts_count')->default(0);
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
        Schema::dropIfExists('target_audiences');
    }
}
