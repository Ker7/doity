<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //LIVE DATA SEEDS
        //$this->call('FieldsSeeder');
        //$this->call('UsersSeeder');
        // + habitid ehk projektid ja nende seosed!
        
        // TEST DATA SEEDs !!!
        
        //$this->call('FieldsSeeder');
        $this->call('UsersSeeder');
        //$this->call('UserFieldSeeder');
        //$this->call('UserFieldHabitDLSeeder2');
        //$this->call('FieldsHabitSeeder2');
        //$this->call('HabitsSeeder');
        //$this->call('BankDaysSeeder');
        
        
        
        
        //$this->call('TagsSeeder');
        //$this->call('HabitTagsSeeder');
    }
}
