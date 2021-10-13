<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourGuideLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_guide_languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('language_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_guide_languages');
    }
}
