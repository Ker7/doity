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
        DB::table('users')->delete();
        
        $users = array(
            array(
                'id' => 1,
                'name' => 'JohSenna',
                'email' => 'js@mail.com',
                'password' => Hash::make('asd'),
                'privilege' => 1,
                'created_at' => Carbon::now()
                ),
            array(
                'id' => 2,
                'name' => 'Kert',
                'email' => 'kert@mail.com',
                'password' => Hash::make('asd'),
                'privilege' => 10,
                'created_at' => Carbon::now()
                ),
            array(
                'id' => 3,
                'name' => 'Andrus',
                'email' => 'andrus@mail.com',
                'password' => Hash::make('asd'),
                'privilege' => 1,
                'created_at' => Carbon::now()
                ),
            array(
                'id' => 4,
                'name' => 'Baltic Steelarc Worker',
                'email' => 'bsa@mail.com',
                'password' => Hash::make('asd'),
                'privilege' => 5,
                'created_at' => Carbon::now()
                )
            );
        
        DB::table('users')->insert($users);
    }
}
