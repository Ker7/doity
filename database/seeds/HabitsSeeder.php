<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class HabitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('habits')->delete();
        
        $fields = array(
            array('name' => 'Tööl',             'author_user' => 25, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()),
            array('name' => 'Talon työt',       'author_user' => 25, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()),
            array('name' => 'test-projekt 1',       'author_user' => 25, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()),
            array('name' => 'test-projekt 2',       'author_user' => 25, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()),
            );
        
        DB::table('habits')->insert($fields);
    }
}
