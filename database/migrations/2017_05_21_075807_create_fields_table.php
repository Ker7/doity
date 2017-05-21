<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->string('color');
            $table->boolean('verified')->default(0);    // Is it verified as a global field?
            $table->integer('author_user');             // Who created the field?
            $table->boolean('clicked');     // @todo remove clicked or not? For giggles... TEST
            
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
        Schema::dropIfExists('fields');
    }
}
