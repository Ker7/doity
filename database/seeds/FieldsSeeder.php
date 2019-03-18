<?php
//namespace Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('fields')->truncate();
        
        $fields = array(
            array('id' => 1,'name' => 'Tervis',             'color' => '#51BB49','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 2,'name' => 'Vaimsus',            'color' => '#BB49B0','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 3,'name' => 'Finants',            'color' => '#39E9B7','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 4,'name' => 'Sotsialiseerumine',  'color' => '#E9E239','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 5,'name' => 'Muusika',            'color' => '#FF0000','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 6,'name' => 'Programmeerimine',   'color' => '#6EABD9','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 7,'name' => 'Töö',                'color' => '#E19438','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now()),
            array('id' => 8,'name' => 'Visuaalmeedia',      'color' => '#784CA8','author_user' => 1,'clicked' => 1, 'verified' => 1, 'created_at' => Carbon::now())
            );
        
        DB::table('fields')->insert($fields);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}