<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Factory;
use Carbon\Carbon;

class UserFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('field_user')->delete();
        
        /* User and Field combinations
         *
         * All 3 users have all 7 Fields linked with them!
         * 
         */
        
        $i = 1;  // index for table id column
        
        foreach (range(1,3) as $user_id){
            foreach (range(1,7) as $field_id){
                DB::table('field_user')->insert([
                    'id' => $i,
                    'user_id' => $user_id,
                    'field_id' => $field_id,
                    'active' => Rand(0,1),
                    'clicked' => 1,
                    'public' => 1,
                    'created_at' => Carbon::now()
                ]);
                $i++;
            }
        }
    }
}
