<?php

use Illuminate\Database\Seeder;

class BankDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank_days')->delete();
        
        $fields = array(
            array('date' => '2017-11-23',
                  'user_id' => '4',
                  'value_decimal' => 0,
                  'comment' => 'Haigusleht'),
            array('date' => '2017-11-22',
                  'user_id' => null,
                  'value_decimal' => 5,
                  'comment' => 'Pühade eelne päev'),
            array('date' => '2017-11-22',
                  'user_id' => 4,
                  'value_decimal' => 3,
                  'comment' => 'Special sellele päevale Anneli 3h test'));
        
        DB::table('bank_days')->insert($fields);
    }
}
