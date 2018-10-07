<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Faker\Factory as Factory;

class UserFieldHabitDLSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dotilogs')->delete();

        //use Faker\Factory as Factory;
        $faker = Factory::create();
        
        $i = 1;
        foreach (range(1,96) as $index) {
            DB::table('dotilogs')->insert([
                //'id' => $i,
                'fieldhabit_id' => rand(5,8),
                
                'date_log' => Carbon::now()->subDays($index)->format('Y-m-d'),//$faker->dateTime('-'.$i.' day')->format('Y-m-d'),
                //'date_log' => $faker->dateTimeBetween('-3 month', 'now')->format('Y-m-d'),
                //'time' => $faker->dateTimeBetween('-1 day', 'now')->format('H:i:s'),  // For Fieldlog it is okay to just use date, time is NULL
                
                'value_decimal' => (Rand(600,1400) / 100),
                'comment' => $faker->sentence,
                'created_at' => Carbon::now()->subDays($index)
            ]);
            $i++;
        }
        
    }
}
