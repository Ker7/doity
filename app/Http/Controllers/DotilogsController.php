<?php

namespace App\Http\Controllers;

use App\User;
use App\FHabit;
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
        $log = new Dotilog;
        
        $log->fieldhabit_id = $request->input('uhid');
        $log->date_log = $request->input('date_log');
        $log->time_log = $request->input('time_log');
        $log->date_log2 = $request->input('date_log');
        $log->time_log2 = $request->input('time_log2');
        $log->is_counting = 0;
        $log->comment = 'MANUAL';
        
        $hours = $this->calculateHoursDifference($log->date_log . $log->time_log, $log->date_log2 . $log->time_log2);
        $log->value_decimal = ( (null !== $request->input('value_decimal')) ? $request->input('value_decimal') : $hours );
            
        $log->save();
        return redirect()->action('HomeController@reflect', [
                    'a' => 0,
                    'uid' => $request->input('uid'),
                    'dtf' => $request->input('dtf'),
                    'dtt' => $request->input('dtt'),
                    'form_reflect_field' => $request->input('form_reflect_field'),
                    'form_reflect_habits' => $request->input('form_reflect_habits'),
                    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forward(Request $request)
    {
        
        $log = new Dotilog;
        
        $log->fieldhabit_id = $request->input('fhid');
        $log->date_log = $request->input('fhdt');
        $log->time_log = '03:00:00';
        
        $log->value_decimal = $request->input('value_decimal');
        
        $log->is_counting = 0;
        $log->comment = $request->input('comment');

        if ($log->save()) {
            $msg='Pangatunnid edukalt üle kantud!';
            $art='alert-success';
        }else {
            $msg='Tundide ülekandmisel tekkis viga.';
            $art='alert-warning';
        }
        
        return redirect()->action('HomeController@calendar', [
                    'a' => 0,
                    'uid' => $request->input('uid'),
                    'dtf' => $request->input('dtf'),
                    ])->with('message', $msg)->with('alert-class', $art);
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
        echo "Edit@DotilogsController.php";
        //echo 'Dotilog@edit, id:'.$id;
        //return redirect()->action('HomeController@reflect');
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
        $log = Dotilog::where('id', $val)->first();
        if ($request->input('uhid') !== null) {
            $log->fieldhabit_id = $request->input('uhid');
        }
        
        // Before and after change log down the change!
        
        $log->date_log = $request->input('date_log');
        $log->time_log = $request->input('time_log');
        $log->date_log2 = $request->input('date_log2');
        $log->time_log2 = $request->input('time_log2');
        $log->is_counting = $request->input('is_counting');
        
        if ($request->input('is_counting') == 0) {
            //$log->is_counting = 0;
            $hours = $this->calculateHoursDifference($log->date_log . $log->time_log, $log->date_log2 . $log->time_log2);
            $log->value_decimal = ( (null !== $request->input('value_decimal')) ? $request->input('value_decimal') : $hours );
        }
        $log->save();
        return redirect()->action('HomeController@reflect', [
                    'a' => 0,
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
    }
    
    /**
     * Finish tracking a log record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dotilog . id
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, $val)
    {
        $this->finishALog($request, $val);
        return redirect()->action('TrackController@index');
    }
        /*
         * @param Dotilog id
         */
    private function finishALog(Request $request, $val)
    {
        $log = Dotilog::where('id', $val)->first();
        $log->date_log2 = Carbon::now()->timezone('Europe/Tallinn')->format('Y-m-d');
        $log->time_log2 = Carbon::now()->timezone('Europe/Tallinn')->hour . ':' . Carbon::now()->format('i') . ':' . Carbon::now()->format('s');

        $hours = $this->calculateHoursDifference($log->date_log . $log->time_log, $log->date_log2 . $log->time_log2);
//break;
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
    public function destroy(Request $request, $id)
    {
        //
        //echo "Search and Destroy! : " . $id;
        $log = Dotilog::where('id', $id)->first();
        $log->delete();
        
        //return redirect()->action('HomeController@reflect');
        return redirect()->action('HomeController@reflect', [
                'a' => 0,
                'uid' => $request->input('uid'),
                'dtf' => $request->input('dtf'),
                'dtt' => $request->input('dtt'),
                'hid' => $request->input('hid'),
                ]);
    }
    
    /* Calculates the time difference.
     * @@todo calculate holy lunch here! By config values
     *
     */
    private function calculateHoursDifference($datetimeFrom, $datetimeTo) {
        
        $d_from = Carbon::parse($datetimeFrom);
        $d_to = Carbon::parse($datetimeTo);
        
        $minusHours = 0;

        if (\Config::has('doti-settings.lunch-start') && \Config::has('doti-settings.lunch-end')) {
            $lunch_start = Carbon::parse($d_from->format('Y-m-d ') . config('doti-settings.lunch-start'));
            $lunch_end = Carbon::parse($d_from->format('Y-m-d ') . config('doti-settings.lunch-end'));
            
            if ($d_from->lt($lunch_start)) {    //Start before lunch
                if ($d_to->gte($lunch_start) && $d_to->lte($lunch_end)) {   //Ends at lunch, end goes to start of the lunch
                    $d_to = Carbon::parse(substr($d_to, 0, 10) . config('doti-settings.lunch-start'));
                }
                if ($d_to->gt($lunch_end)) {  //Ends after lunch, minus lunch!
                    $minusHours = 0.5;
                }
            }
            
            if ($d_from->gte($lunch_start) && $d_from->lte($lunch_end)) {   // Start during lunch, start goes to lunch end
                $d_from = Carbon::parse(substr($d_from, 0, 10) . config('doti-settings.lunch-end'));
                if ($d_to->gte($lunch_start) && $d_to->lte($lunch_end)) {   //Ends at lunch, end goes to start of the lunch
                    $minusHours = 9999999999;
                }
            }
        }
        $hours = max( ($d_from->diffInSeconds($d_to)/3600) - $minusHours, 0);
        return $hours;
    }
}
