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
            array('id' => 1,'name' => 'Arenda',             'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 2,'name' => 'Eine',               'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 3,'name' => 'Kitarrimäng',        'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 4,'name' => 'Komponeerimine',     'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 5,'name' => 'Band',               'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 6,'name' => 'Õpi',                'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 7,'name' => 'Ost',                'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 8,'name' => 'Teeni',              'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 9,'name' => 'Rattasõit',          'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 10,'name' => 'Trenn',             'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 11,'name' => 'Tarbi',             'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 12,'name' => 'Loe',               'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 13,'name' => 'Meditatsioon',      'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => false, 'created_at' => Carbon::now()),
            array('id' => 14,'name' => '_log',              'author_user' => Rand(1,3), 'public' => Rand(0,1), 'internal' => true, 'created_at' => Carbon::now())
            );
        
        //"#FF6384","#4BC0C0","#9476AB","#E7E9ED","#36A2EB","#D4BA6A","#420029","#E7E9ED"
        DB::table('habits')->insert($fields);
    }
}
