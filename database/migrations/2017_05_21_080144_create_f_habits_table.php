<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFHabitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userfield_habit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userfield_id');
            $table->integer('habit_id');    // IF no habit then it's a Field datalog, the Habit is just tracking that
                                                        // NOT NULLABLE! Must have at least internal habits!!!
            
            $table->boolean('internal')->default(false);// If internal,  then means mabye plugged-in or somthing in-sys., like Field Datalog
            
                /* How is This Habit being measured? */
                /* @Todo Gets name & type for premade Units ~from~ another table
                 * 1 - integer - 1, 6314.34, 3.1415
                 * 2 - timespan - 17.3 sec, 4,33 mins, 2:13:23 (2h13m23s)
                 * 3 - decimals - 1, 6314.34, 3.1415
                 */
            $table->integer('unit_id')->default(1); // IF Field datalog, then unit numeric
            
                /* Name like "pieces", "pages", "things" we use to count
                 */
            $table->string('unit_name')->nullable()->default(NULL);
            
            $table->boolean('active')->default(true);
            $table->boolean('public')->default(false);
            
            // $table->string('habittag_id'); For ManyToMany we don't need a key here
            $table->text('comment');
            
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
        Schema::dropIfExists('userfield_habit');
    }
}
