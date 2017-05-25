<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FhabitTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fhabit_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fieldhabit_id');
            $table->integer('tag_id');    // IF no habit then it's a Field datalog, the Habit is just tracking that
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
        Schema::dropIfExists('fhabit_tag');
    }
}
