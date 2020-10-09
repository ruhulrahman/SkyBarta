<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',40);
            $table->string('slug',100)->unique()->default(rand(1000,1000000000));
            $table->string('email',100)->unique();
            $table->string('mobile',15)->unique()->nullable();
            $table->string('password');
            $table->unsignedInteger('role_id')->references('id')->on('roles')->default(1);
            $table->mediumText('aboutme')->nullable();
            $table->unsignedInteger('gender_id')->references('id')->on('genders');
            $table->string('dob', 15); //date of birth
            $table->unsignedInteger('m_income')->nullable(); //monthly income
            $table->unsignedInteger('fam_members')->nullable(); //Family Members number
            $table->unsignedInteger('blood_id')->nullable();
            $table->unsignedInteger('profession_id')->nullable();
            $table->unsignedInteger('active')->default(1); //1=active, 0=disable, 2=block
            $table->string('photo')->nullable();
            $table->string('hobby')->nullable();
            $table->unsignedInteger('religion_id')->references('id')->on('religions')->nullable();
            $table->unsignedInteger('relation_id')->references('id')->on('relations')->nullable(); //marrital status
            $table->string('quote', 100)->nullable(); //marrital status
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
