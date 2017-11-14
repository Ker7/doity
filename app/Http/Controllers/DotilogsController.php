<?php

namespace App\Http\Controllers;

use App\Dotilog;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DotilogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function show(Dotilog $dotilog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function edit(Dotilog $dotilog, $id)
    {
        echo 'Dotilog@edit, id:'.$id;
        return redirect()->action('HomeController@reflect');
    }

    /**
     * Update by admin, log record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $val)//Dotilog $dotilog)
    {
        echo "DotilogsController.php@update";
        //print_r($request->input());
        //return ;
        //$request->input('date_log')
        //$request->input('time_log')
        //$request->input('date_log2')
        //$request->input('time_log2')
        //$request->input('is_counting')
        //$request->input('user_id')
        //$request->input('')
        
        $log = Dotilog::where('id', $val)->first();
        
        $log->date_log = $request->input('date_log');
        $log->time_log = $request->input('time_log');
        $log->date_log2 = $request->input('date_log2');
        $log->time_log2 = $request->input('time_log2');
        $log->is_counting = $request->input('is_counting');
        
        $hours = $this->calculateHoursDifference($log->date_log . $log->time_log, $log->date_log2 . $log->time_log2);
        $log->value_decimal = ( (null !== $request->input('value_decimal')) ? $request->input('value_decimal') : $hours );
        //echo (null !== $request->input('value_decimal') ? 'decimal_set' : 'nok');
        
        
        $log->save();
        //print_r($log);
        //echo 'Dotilog@update, id:'.$dotilog->id;
        
        return redirect()->action('HomeController@reflect', [
                    'uid' => $request->input('uid'),
                    'dtf' => $request->input('dtf'),
                    'dtt' => $request->input('dtt'),
                    'form_reflect_field' => $request->input('form_reflect_field'),
                    'form_reflect_habits' => $request->input('form_reflect_habits'),
                    ]);
    }
/**
     * Finish tracking a log record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function start(Request $request)//Dotilog $dotilog)
    {
        // IF singular habit tracking then close others. Open logs variable is in Form, multiple incase value is changed.
        if (config('doti-settings.single-habit-tracking')) {
            $multiple_open_logs = explode(',', str_replace(' ', '', $request->input('open_logs')));
            foreach($multiple_open_logs as $num) {
                if ( (int)$num == $num && (int)$num > 0 ){
                    $this->finishALog($request, $num);
                }
            }
        }
        
        $log = new Dotilog;

        $log->fieldhabit_id = $request->input('form-track-habits');
        $log->date_log = Carbon::now()->timezone('Europe/Tallinn')->format('Y-m-d');
        $log->time_log = Carbon::now()->timezone('Europe/Tallinn')->hour . ':' . Carbon::now()->format('i') . ':' . Carbon::now()->format('s');
        $log->is_counting = 1;
        $log->ip_address = $request->input('ip_address');
        $log->save();
        
        return redirect()->action('TrackController@index');
        //return;
    }
    
    /**
     * Finish tracking a log record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, $val)//Dotilog $dotilog)
    {
        //$log = Dotilog::where('id', $val)->first();
        //
        //$log->date_log2 = Carbon::now()->timezone('Europe/Tallinn')->format('Y-m-d');
        //$log->time_log2 = Carbon::now()->timezone('Europe/Tallinn')->hour . ':' . Carbon::now()->format('i') . ':' . Carbon::now()->format('s');
        //
        //$secondsPassedUntilNow = Carbon::parse($log->date_log2 . $log->time_log2)->diffInSeconds(Carbon::parse($log->date_log . $log->time_log));
        //$hours = $secondsPassedUntilNow/3600;
        //
        //$log->value_decimal = $hours;
        //$log->is_counting = 0;
        //$log->save();
        
        $this->finishALog($request, $val);
        
        return redirect()->action('TrackController@index');
    }
        /*
         * @param FHabit id
         */
    private function finishALog(Request $request, $val)//Dotilog $dotilog)
    {
        $log = Dotilog::where('id', $val)->first();

        $log->date_log2 = Carbon::now()->timezone('Europe/Tallinn')->format('Y-m-d');
        $log->time_log2 = Carbon::now()->timezone('Europe/Tallinn')->hour . ':' . Carbon::now()->format('i') . ':' . Carbon::now()->format('s');
        
        //$secondsPassedUntilNow = Carbon::parse($log->date_log2 . $log->time_log2)->diffInSeconds(Carbon::parse($log->date_log . $log->time_log));
        //$hours = $secondsPassedUntilNow/3600;
        
        $hours = $this->calculateHoursDifference($log->date_log . $log->time_log, $log->date_log2 . $log->time_log2);
        
        $log->value_decimal = $hours ;
        
        $log->is_counting = 0;
        $log->ip_address2 = $request->input('ip_address');
        
        $log->save();
        
        return ;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dotilog $dotilog)
    {
        //
    }
    
    /* Calculates the time difference.
     * @@todo calculate holy lunch here! By config values
     *
     */
    private function calculateHoursDifference($datetimeFrom, $datetimeTo) {
        
        $d_from = $datetimeFrom;
        $d_to = $datetimeTo;
        
        $hours = Carbon::parse($d_from)->diffInSeconds(Carbon::parse($d_to))/3600;
        
        return $hours;
    }
}
