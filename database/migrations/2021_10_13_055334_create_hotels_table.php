<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('picture')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('status', 30)->nullable();             
            $table->integer('number_of_flag')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('number_of_star')->nullable();
            $table->integer('number_of_room')->nullable();
            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->bigInteger('type_id')->unsigned()->nullable();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
