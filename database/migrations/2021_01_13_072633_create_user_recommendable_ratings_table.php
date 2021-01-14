<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRecommendableRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_recommendable_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('rating');
            $table->foreignId('recommendable_id')
                  ->references('id')
                    ->on('recommendables');
            $table->timestamps();

            $table->unique(['username', 'recommendable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_recommendable_ratings');
    }
}
