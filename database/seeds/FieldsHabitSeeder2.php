<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Faker\Factory as Factory;

class FieldsHabitSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userfield_habit')->delete();
        
        $faker = Factory::create();
        
        /* Kõigepealt teeme iga fieldi trackimiseks special Habiti, mida ei kuvata välja ega midagi
         *
         * Esimene habit on LIHTSALT TÖÖL
         */
        foreach (range(1,2) as $userfield_id){
            foreach (range(1,4) as $habit_id){
                DB::table('userfield_habit')->insert([
                    'internal' => false, //
                    'userfield_id' => $userfield_id,
                    //'date' => $faker->dateTimeBetween('-3 month', 'now')->format('Y-m-d'),
                    'habit_id' => $habit_id,       //Hardcoded "_log" named habit
                    
                    'unit_id' => 1,         // IF Field datalog, then unit is piece
                    'unit_name' => "h",     
                    
                    //'value' => Rand(0,100),
                    //'field_id' => $index,
                    'active' => 1,          // WWW III PPP
                    'public' => 1,
                    'created_at' => Carbon::now(),
                    
                    'comment' => ''
                    //'comment' => $faker->sentence
                ]);
            }
        }
        
    }
}
