<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReadToMessages extends Migration
{

    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('read')->after('to')->default(false);
        });
    }


    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('read');
        });
    }
}
