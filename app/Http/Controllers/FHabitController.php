<?php

namespace App\Http\Controllers;

use App\FHabit;
use App\Habit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

class FHabitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "FHabit@index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "FHabit@create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $a = "";
        
        $post_type = $request->input('form_name');
        
        $user_field = $request->input('field_id');
        $habit_name = $request->input('name');
        
        $newHabit = new Habit;      // new habit!
        $newHabit->name = $habit_name;
        $newHabit->author_user = Auth::user()->id;
        $newHabit->internal = 0;
        $newHabit->public = 0;
        $newHabit->save();
        
        $newFHabit = new FHabit;        // new Field Habit
        $newFHabit->userfield_id = $user_field;
        $newFHabit->habit_id = $newHabit->id;
        $newFHabit->internal = 0;
        $newFHabit->unit_id = 1;        // 1 - placeholder for decimal! 2-time, 3-percentage
        $newFHabit->unit_name = $request->input('unit_name');
        $newFHabit->active = 1;
        $newFHabit->public = 0;
        $newFHabit->comment = $request->input('comment');
        $newFHabit->save();

        return redirect()->action('HomeController@index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function show(FHabit $fHabit)
    {
        return "FHabit@show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $fieldHabit = FHabit::where('id', $request->input('fieldhabit_id'))->first();   
        
        switch($request->input('form_name')) {
            case('fieldhabit_active'): $fieldHabit->toggleActive(); break;
            case('fieldhabit_public'): $fieldHabit->togglePublic(); break;
            default: break;
        }
        
        // @todo errmsg if
        return redirect()->action('HomeController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FHabit $fHabit)
    {
        return "FHabit@update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FHabit  $fHabit
     * @return \Illuminate\Http\Response
     */
    public function destroy(FHabit $fHabit)
    {
        return "FHabit@destory";
    }
}
