<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermanentAddressesTable extends Migration
{

    public function up()
    {
        Schema::create('permanent_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->text('division');
            $table->text('district');
            $table->text('police_station');
            $table->text('postal');
            $table->text('village');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permanent_addresses');
    }
}
