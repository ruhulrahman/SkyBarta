<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->references('id')->on('users');
            $table->unsignedInteger('company_id')->references('id')->on('companies');
            $table->string('title', 50);
            $table->longText('description');
            $table->string('salary_range', 25)->nullable();
            $table->date('deadline');
            $table->unsignedInteger('category_id')->references('id')->on('professions');
            $table->unsignedInteger('privacy_id')->references('id')->on('privacies');
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
        Schema::dropIfExists('jobs');
    }
}
