<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThanasTable extends Migration
{

    public function up()
    {
        Schema::create('thanas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('district_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('thanas');
    }
}
