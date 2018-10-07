<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_days', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('user_id')->nullable();     //IF user null -> All the users, overriden by personal settings
            $table->decimal('value_decimal', 12, 2)->nullable()->default(0);
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('bank_days');
    }
}
