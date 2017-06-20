<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDotilogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dotilogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fieldhabit_id');
            $table->date('date_log');
            $table->time('time_log')->nullable();
            
            $table->text('tag_ids')->nullable();
            
              /* Idee on kõikide andmete salvestamiseks kasutada decimali DB's */
            $table->decimal('value_decimal', 12, 2)->nullable();
            //$table->integer('value_int');
            //$table->integer('value_time');
            
            $table->text('comment')->nullable();
            
            $table->timestamps();
            /* @todo Custom attachments (-> Images, files w/e */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dotilogs');
    }
}
