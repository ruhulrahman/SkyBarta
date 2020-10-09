<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostcodesTable extends Migration
{

    public function up()
    {
        Schema::create('postcodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('division_id');
            $table->unsignedInteger('district_id');
            $table->string('upazila');
            $table->string('postOffice');
            $table->unsignedInteger('postCode');
        });
    }

    public function down()
    {
        Schema::dropIfExists('postcodes');
    }
}
