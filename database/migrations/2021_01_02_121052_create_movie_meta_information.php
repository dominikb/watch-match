<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieMetaInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_meta_information', function (Blueprint $table) {
            $table->id();
            $table->integer('movie_id');
            $table->string('original_title',1024);
            $table->boolean('available_on_netflix')->default(false);
            $table->timestamp('providers_checked_at')->nullable();
            $table->boolean('adult');
            $table->boolean('video');
            $table->double('popularity');
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
        Schema::dropIfExists('movie_meta_information');
    }
}
