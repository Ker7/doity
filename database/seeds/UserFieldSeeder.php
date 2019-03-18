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
         * All 4 users have all 8 Fields linked with them!
         * 
         */
        
        $i = 1;  // index for table id column
        foreach (range(1,4) as $user_id){
            foreach (range(1,8) as $field_id){
                DB::table('field_user')->insert([
                    'id' => $i,
                    'user_id' => $user_id,
                    'field_id' => $field_id,
                    'active' => 1,
                    'clicked' => 1,
                    'public' => ($user_id==1 OR $user_id==2?1:0),       //First two users are so Called Admins who generate this stuff for generat purposes
                    'created_at' => Carbon::now()
                ]);
                $i++;
            }
        }

    }
}
