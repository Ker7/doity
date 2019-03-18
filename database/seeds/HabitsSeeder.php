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
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('habits')->truncate();
        
        $habits = array();
      /*$habits[] = ['id' => 1,             Database ID
                    'name' => 'Tööl',       Name visual
                    'author_user' => 1,     Who created this Habit
                    'public' => 1,          Is it publicly available to add for self?
                    'internal' => false,    Is it only for system use internally and not for users?
                    'created_at' => Carbon::now()]; When made? */   
      //$habits[] = ['id' => 1,   'name' => 'Tööl', 'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
//Universaalne
        $habits[] = ['name' => 'Õppimine',  'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 1 Tervis
        $habits[] = ['name' => 'Ujumine',   'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Treening',  'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Rattasõit', 'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Tarbimine', 'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Magamine',  'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 2 Vaimsus
        $habits[] = ['name' => 'Lugemine',  'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Vaatamine', 'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Mediteerimine','author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Aitamine',  'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Meenutus',  'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 3 Finants
        $habits[] = ['name' => 'Ost',       'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Müük',      'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 4 Sotsialiseerumine
        $habits[] = ['name' => 'Kohtumine', 'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 5 Muusika
        $habits[] = ['name' => 'Kitarr',    'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Kirjutamine','author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Bänd',      'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Salvestamine','author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 6 Programmeerimine
        $habits[] = ['name' => 'Arendamine','author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 7 Töö
        $habits[] = ['name' => 'Log',       'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
// 8 Visuaalmeedia
        $habits[] = ['name' => 'Pildistamine','author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Fototöötlus','author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Filmimine', 'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        $habits[] = ['name' => 'Montaaž',   'author_user' => 1, 'public' => 1, 'internal' => false, 'created_at' => Carbon::now()];
        
        DB::table('habits')->insert($habits);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
