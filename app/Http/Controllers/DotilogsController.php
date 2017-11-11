<?php

namespace App\Http\Controllers;

use App\Dotilog;
use Illuminate\Http\Request;

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $val)//Dotilog $dotilog)
    {
        //print_r($val);
        
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Dotilog  $dotilog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dotilog $dotilog)
    {
        //
    }
}
