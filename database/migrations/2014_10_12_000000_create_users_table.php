<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('fb_id');
            $table->string('name');
            $table->string('slug');
            $table->integer('user_role_id')->unsigned();
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['M', 'F']);
            $table->date('dob');
            $table->string('avatar');
            $table->boolean('is_blocked');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
