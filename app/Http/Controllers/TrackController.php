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
use App\Dotilog as Dotilog;

use Carbon\Carbon;

//use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route as Route;

class TrackController extends Controller
{
    public function index() {
        // get User
        $user = User::where('id', Auth::id())->first();

        // get User Fields
        $uf = UserField::where('user_id', Auth::id())->get();

        // get each UserFields User Habit       
        foreach($uf as $userfields){
            $habb = $userfields->getFieldHabits;
        }
        
        $data = [ 'userFields' => $uf,
                  'nowDate' => Carbon::now()->timezone('Europe/Tallinn')->format('m/d/Y'),
                  'nowTime' => Carbon::now()->timezone('Europe/Tallinn')->hour . ':' . Carbon::now()->format('i') ];
        //return redirect()->action('HomeController@index');
        //echo "</body></html>";
        return view('track', $data);
    }
    
    public function post(Request $request) {
        
        //print_r($request->input());
        
        $dl = new Dotilog;
        
        $dl->fieldhabit_id = $request->input('form-track-habits');
        $dl->date_log = $request->input('date');
        $dl->time_log = $request->input('time');
        $dl->tag_ids = implode(',', $request->input('habit-tags'));
        $dl->value_decimal = $request->input('habit-value');
        $dl->comment = $request->input('comment');
        
        $dl->save();
        
        return redirect()->action('TrackController@index');
    }
}
