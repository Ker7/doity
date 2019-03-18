<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');  //For re-seeding so it woulnd add more more more ID's and always started from 1
        DB::table('users')->truncate();

        $sisse = array();

        $sisse[] = ['name' => 'Kert',       'email' => 'kert.mottus@gmail.com', 'privilege' => 10,  'password' => Hash::make('asd')]; 
        $sisse[] = ['name' => 'Gerli',      'email' => 'gerli.paju@gmail.com',  'privilege' => 10,  'password' => Hash::make('asd')]; 
        $sisse[] = ['name' => 'Moderator',  'email' => 'mode@gmail.com',        'privilege' => 5,   'password' => Hash::make('asd')]; 
        $sisse[] = ['name' => 'User',       'email' => 'user@gmail.com',        'privilege' => 1,   'password' => Hash::make('asd')]; 
        
        DB::table('users')->insert($sisse);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
