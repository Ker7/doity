<?php

namespace App\Http\Controllers;

use App\UserField;
use App\FHabit;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class testController extends Controller
{
    public function index()
    {
        //$this->iii(8);
        //$this->iii(9);
        //$this->iii(10);
        //$this->iii(11);
        //$this->iii(12);
        //$this->iii(13);
        
        //Küsitakse userfield'i ajaxiga, Habiteid! Teeme nii
        //return "UFCont@index! Count: " . action('FHabitController@index');
        
        Mail::send( 'emails.test', ['name' => "Novvv"], function($message)
        {
            $message
                ->to( 'kert.mottus@gmail.com', 'Some Guy' )
                ->from('tere@bla.ee')
                ->subject('tere');
        } );
    }
    
    public function iii($af) {
        echo '<br>';
                // Ajax request gives the requested UserField ID
        $uf = $af;
        
        // Now we gonna find all this UserField's habits
        $habits = FHabit::where('userfield_id', $uf)->get();
        
        $names = "";
        foreach ($habits as $habit) {
            echo '<br>'.$habit->getHabit->name;
        }
        echo '<br>'.count($habits);
    }
}
