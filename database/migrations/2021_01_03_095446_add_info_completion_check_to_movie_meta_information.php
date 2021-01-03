<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoCompletionCheckToMovieMetaInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_meta_information', function (Blueprint $table) {
            $table->timestamp('check_for_recommendability_at')->nullable();
            $table->boolean('recommendable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_meta_information', function (Blueprint $table) {
            $table->removeColumn('recommendable');
            $table->removeColumn('check_for_recommendability_at');
        });
    }
}
