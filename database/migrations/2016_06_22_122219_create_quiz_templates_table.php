<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->longText('html_data');
            $table->string('og_image');
            $table->integer('total_images')->unsigned();
            $table->integer('total_textareas')->unsigned();
            $table->boolean('has_title')->default(true);
            $table->boolean('has_image_caption')->default(false);
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
        Schema::drop('quiz_templates');
    }
}
