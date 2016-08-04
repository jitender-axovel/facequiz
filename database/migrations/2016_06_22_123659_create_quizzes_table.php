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
            $table->integer('quiz_template_id')->unsigned();
            $table->foreign('quiz_template_id')->references('id')->on('quiz_templates');
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('locale');
            $table->string('background_image');
            $table->text('description');
            $table->integer('total_facts')->unsigned();
            $table->boolean('show_own_profile_picture')->default(false);
            $table->boolean('show_user_name')->default(false);
            $table->boolean('show_friend_pictures')->default(false);
            $table->boolean('show_friend_name')->default(false);
            $table->boolean('is_active')->default(false)->index();
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
        Schema::drop('quizzes');
    }
}
