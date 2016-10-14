<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('fb_code')->unique();
            $table->string('fb_page_code');
            $table->longText('fb_like');
            $table->longText('fb_widget');
            $table->string('direction');
            $table->longText('strings');
            $table->integer('order')->unsigned();
            $table->boolean('isActive')->default(false);
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
        Schema::drop('languages');
    }
}
