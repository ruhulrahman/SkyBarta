<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeoLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('geo_locations', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedInteger('user_id');
        //     $table->string('address_address')->nullable();
        //     $table->double('address_latitude')->nullable();
        //     $table->double('address_longitude')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('geo_locations');
    }
}
