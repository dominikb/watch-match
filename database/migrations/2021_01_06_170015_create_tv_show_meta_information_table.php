<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvShowMetaInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_show_meta_information', function (Blueprint $table) {
            $table->id();
            $table->integer('tv_show_id');
            $table->string('original_name', 1024);
            $table->double('popularity');
            $table->boolean('available_on_netflix')->default(false);
            $table->timestamp('providers_checked_at')->nullable();
            $table->timestamp('check_for_recommendability_at')->nullable();
            $table->boolean('recommendable')->default(false);
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
        Schema::dropIfExists('tv_show_meta_information');
    }
}
