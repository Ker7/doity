<?php

use Illuminate\Database\Seeder;

class HabitTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fhabit_tag')->delete();
        
        $tags = array(
            array('id' => 1,'tag_id' => 1,'fieldhabit_id' => 24),
            array('id' => 2,'tag_id' => 2,'fieldhabit_id' => 24),
            array('id' => 3,'tag_id' => 3,'fieldhabit_id' => 24),
            array('id' => 4,'tag_id' => 4,'fieldhabit_id' => 24),
            array('id' => 5,'tag_id' => 5,'fieldhabit_id' => 24)
            );
        
        DB::table('fhabit_tag')->insert($tags);
    }
}
