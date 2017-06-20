<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();
        
        $tags = array(
            array('id' => 1,'name' => 'lõuna'),
            array('id' => 2,'name' => 'söök'),
            array('id' => 3,'name' => 'magus'),
            array('id' => 4,'name' => 'majapidamine'),
            array('id' => 5,'name' => 'lõbu')
            );
        
        DB::table('tags')->insert($tags);
    }
}
