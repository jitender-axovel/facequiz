<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->integer('quiz_template_id')->unsigned();
            $table->foreign('quiz_template_id')->references('id')->on('quiz_templates');
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('background_image');
            $table->text('description');
            $table->boolean('show_own_profile_picture')->default(false);
            $table->boolean('show_user_name')->default(false);
            $table->boolean('show_friend_pictures')->default(false);
            $table->boolean('show_friend_name')->default(false);
            $table->boolean('is_active')->default(false)->index();
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
        Schema::drop('quizzes');
    }
}