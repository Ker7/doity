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
        
        $nimed = ['Ain Prants', 'Aivar Filing', 'Allar Aalde', 'Anneli Uibopuu', 'Deniss Štepa', 'Enar Kolats', 'Erki Kärgenberg', 'Igor Tretyak', 'Ivar Veelma', 'Kalju Tavel', 'Kalle Hellamaa', 'Lembit Pähn', 'Maido Uibopuu', 'Meigo Mõttus', 'Rauno Uibopuu', 'Rene Kilter', 'Renee Miitel', 'Siim Hirse', 'Tarmo Kahk', 'Väino Pähn', 'Ville Värton', 'Voldemar Talv', 'Vjatseslav Andritski', 'Vesa Viitanen'];
        $emailid = ['ain.prants@balticsteelarc.ee', 'aivar.filing@balticsteelarc.ee', 'allar.aalde@balticsteelarc.ee', 'anneli.uibopuu@balticsteelarc.ee', 'deniss.štepa@balticsteelarc.ee', 'enar.kolats@balticsteelarc.ee', 'erki.kärgenberg@balticsteelarc.ee', 'igor.tretyak@balticsteelarc.ee', 'ivar.veelma@balticsteelarc.ee', 'kalju.tavel@balticsteelarc.ee', 'kalle.hellamaa@balticsteelarc.ee', 'lembit.pähn@balticsteelarc.ee', 'maido.uibopuu@balticsteelarc.ee', 'meigo.mõttus@balticsteelarc.ee', 'rauno.uibopuu@balticsteelarc.ee', 'rene.kilter@balticsteelarc.ee', 'renee.miitel@balticsteelarc.ee', 'siim.hirse@balticsteelarc.ee', 'tarmo.kahk@balticsteelarc.ee', 'väino.pähn@balticsteelarc.ee', 'ville.värton@balticsteelarc.ee', 'voldemar.talv@balticsteelarc.ee', 'vjatseslav.andritski@balticsteelarc.ee', 'vesa.viitanen@balticsteelarc.ee'];
        $privileegid = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 5, 1, 1, 1, 1, 1, 1, 1, 1, 8, 8];
        foreach ($privileegid as $am => $um){
            $paroolid[$am] = Hash::make('asd');
        }
        // = // REM PAROOLI ARRAY
        $sisse = array();
        
        //foreach ($nimed as $k => $nimi) {
        //    $sisse[] = ['name' => $nimed[$k],
        //                'email' => $emailid[$k],
        //                'privilege' => $privileegid[$k],
        //                'password' => Hash::make($paroolid[$k])
        //                ]; 
        //}
        $sisse[] = ['name' => 'Kert',
            'email' => 'kert.mottus@gmail.com',
            'privilege' => 10,
            'password' => Hash::make('asd')
            ]; 
        $sisse[] = ['name' => 'Gerli',
            'email' => 'gerli.paju@gmail.com',
            'privilege' => 10,
            'password' => Hash::make('asd')
            ]; 
        
        DB::table('users')->insert($sisse);
    }
}
