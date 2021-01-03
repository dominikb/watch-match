<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchProviderEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_provider_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('movie_id');
            $table->string('country_code');
            $table->string('type');
            $table->integer('display_priority');
            $table->string('logo_path');
            $table->integer('provider_id');
            $table->string('provider_name');
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
        Schema::dropIfExists('watch_provider_entries');
    }
}
