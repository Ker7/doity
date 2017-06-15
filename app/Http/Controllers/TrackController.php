<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\User as User;
use App\Field as Field;
use App\UserField as UserField;
use App\Habit as Habit;
use App\FHabit as FHabit;

use Carbon\Carbon;

use Illuminate\Support\Facades\Route as Route;

class TrackController extends Controller
{
    //
    public function index() {
        
        $user = User::where('id', Auth::id())->first();
        $uf = UserField::where('user_id', Auth::id())->get();
        $fh = array();
        
        foreach($uf as $userfields){
            $hab = FHabit::where('userfield_id', $userfields->id)->get(); //$userfields->id;
            foreach ($hab as $hh){
                $hh->getHabit;
            }
            
            $fh[] = $hab;
        }
        
        print_r($user->name);
        
        foreach ($uf as $a){
            print($a->getField->name);
        }
        foreach ($fh as $b){
            //print($b->getHabit->name);
        }
        
        //print_r($uf);
        //print_r($fh);
        
        //return redirect()->action('HomeController@index');
    
    }
}
