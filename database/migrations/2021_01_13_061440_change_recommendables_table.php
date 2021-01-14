<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRecommendablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recommendables', function(Blueprint $table) {
            $table->integer('original_id');
            $table->string('type');
            $table->renameColumn('sub_title', 'runtime');
            $table->string('image_path', 1024);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recommendables', function(Blueprint $table) {
            $table->renameColumn('runtime', 'sub_title');
            $table->dropColumn('image_path');
            $table->dropColumn('type');
            $table->dropColumn('original_id');
        });
    }
}
