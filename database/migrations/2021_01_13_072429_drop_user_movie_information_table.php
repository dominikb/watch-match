<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUserMovieInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('user_movie_information');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('user_movie_information', function (Blueprint $table) {
            $table->id();
            $table->integer('movie_id');
            $table->string('username');
            $table->string('rating');
            $table->timestamps();
        });
    }
}
