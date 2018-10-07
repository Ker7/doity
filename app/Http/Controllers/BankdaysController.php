<?php

namespace App\Http\Controllers;

use App\Http\Requests;
//use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;

use App\User as User;
use App\Field as Field;
use App\UserField as UserField;
use App\Habit as Habit;
use App\Dotilog as Dotilog;
use App\FHabit as FHabit;
use App\BankDays as BankDays;
use App\BankValues as BankValues;
//use Illuminate\Http\Request;

use Carbon\Carbon;

class BankdaysController extends Controller
{
    //
    public function store(Request $request){
        
        print_r('<PRE> store');
        print_r( Input::get() );
        print_r('</PRE>');
        
        $start_date = Carbon::Parse( Input::get('bdatefrom') );
        $end_date = Carbon::Parse( Input::get('bdateto') );
        
        echo $start_date->diffInDays($end_date) . '<br />';
        
        $dates = [];    
        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
    
        foreach ($dates as $dates_to_bank) {
            $bankDay = new BankDays;
            $bankDay->date = $dates_to_bank;
            $bankDay->user_id = Input::get('uid');
            $bankDay->value_decimal = Input::get('value_decimal');
            $bankDay->comment = Input::get('comment');
            $bankDay->save();
        }
        
        return redirect()->action('HomeController@calendar', [
                    'a' => 0,
                    'uid' => Input::get('uid'),
                    'dtf' => Input::get('dtf'),
                    ])->with('message', 'Tunniaja täpsustus lisatud')->with('alert-class', 'alert-success');
    }
    
    public function update(Request $request, BankDays $bankDays){
        
        print_r('<PRE> update');
        print_r( Input::get() );
        print_r('</PRE>');
        
        // Get the bankday by the ID
        $msg = '';
        $bankDay = BankDays::where('id', Input::get('bid'))->first();
        
        if (Input::get('delete') == 'delete') {
            $bankDay->delete();
            $msg = 'Kanne kustutatud';
        } else {
            $bankDay->date = Input::get('bdate');
            $bankDay->value_decimal = Input::get('value_decimal');
            $bankDay->comment = Input::get('comment');
            $bankDay->save();
            $msg = 'Kanne muudetud';
        }
        
        //return redirect('calendar');
    
        return redirect()->action('HomeController@calendar', [
                    'a' => 0,
                    'uid' => Input::get('uid'),
                    'dtf' => Input::get('dtf'),
                    ])->with('message', $msg)->with('alert-class', 'alert-success');
    }
    
    public function destroy() {
        return "OK";
    }
    
}
