<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAppliesTable extends Migration
{

    public function up()
    {
        Schema::create('job_applies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('job_id')->references('id')->on('jobs');
            $table->unsignedInteger('applier_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applies');
    }
}
