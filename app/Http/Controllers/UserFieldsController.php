<?php

namespace App\Http\Controllers;

use App\UserField;
use App\FHabit;
use Illuminate\Http\Request;

class UserFieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return "UFCont@index!";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetFieldHabits(Request $request)
    {
        // Ajax request gives the requested UserField ID
        $uf = $request->input('userfield_id');
        
        // Now we gonna find all this UserField's habits
        $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->get();
        
        //$names = "";
        foreach ($habits as $habit) {
            $habit->getHabit->name;
        }
        
        //Küsitakse userfield'i ajaxiga, Habiteid! Teeme nii
        return $habits->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "UFCont@create!";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "UFCont@store!";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserField  $userField
     * @return \Illuminate\Http\Response
     */
    public function show(UserField $userField)
    {
        return "UFCont@show!";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserField  $userField
     * @return \Illuminate\Http\Response
     */
    public function edit(UserField $userField)
    {
        return "UFCont@edit!";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserField  $userField
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserField $userField)
    {
        return "UFCont@update!";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserField  $userField
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserField $userField)
    {
        return "UFCont@destroy!";
    }
}
