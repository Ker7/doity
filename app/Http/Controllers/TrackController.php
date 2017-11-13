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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index() {
        
        $privilege = User::where('id', Auth::id())->first()->privilege;

        if ($privilege > 8) {
            return $this->highLevelTracking();
        } else {
            return $this->timerTracking();
        }
    }
    
    public function post(Request $request) {
        
        //kui GET dotilog_id on olemas siis on edit!
        
        $dl = new Dotilog;
        
        $dl->fieldhabit_id = $request->input('form-track-habits');
        $dl->date_log = Carbon::parse($request->input('date'))->format('Y-m-d');
        $dl->time_log = $request->input('time');
        
        echo is_array($request->input('habit-tags'));
        
        //if (count($request->input('habit-tags')) > 0) {
        if (is_array($request->input('habit-tags'))) {
            $dl->tag_ids = implode(',', $request->input('habit-tags'));
        }
        //$dl->tag_ids = implode(',', $request->input('habit-tags'));
        
        $dl->value_decimal = $request->input('habit-value');
        $dl->comment = $request->input('comment'); 
        //$dl->comment = Carbon::parse($request->input('date'))->format('Y-d-m');
        
        $dl->save();
        
        return redirect()->action('TrackController@index');
    }
    
    private function highLevelTracking() {
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

        return view('track', $data);
    }
    
    private function timerTracking() {
        // get User
        $user = User::where('id', Auth::id())->first();
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        // get User Fields
        $uf = UserField::where('user_id', Auth::id())->get();
        
        $newLog = new Dotilog;
        $habb = array();    //User Field Habits
        
        // get each UserFields User Habit       
        foreach($uf as $userfields){
            if ($is_admin){
                $habb[] = $userfields->getFieldHabits;
            } else {
                $habb[] = $userfields->getFieldActiveHabits;
            }
        }
        
        $openLogs = array();
        foreach($habb as $ab){      //FieldHabits is nested within Fields, go deeper...
            foreach($ab as $a){
                $openLogs[] = Dotilog::where('fieldhabit_id', $a->id)->where('is_counting', true)->get();
            }
        }

        $data = [ 'newLog' => $newLog,
                  'userFields' => $uf,
                  'nowDate' => Carbon::now()->timezone('Europe/Tallinn')->format('m/d/Y'),
                  'nowTime' => Carbon::now()->timezone('Europe/Tallinn')->hour . ':' . Carbon::now()->format('i'),
                  'openLogs' => $openLogs ];

        return view('track-timer', $data);
    }
}
