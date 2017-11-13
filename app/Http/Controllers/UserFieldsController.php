<?php

namespace App\Http\Controllers;

use App\User;
use App\UserField;
use App\FHabit;
use App\Tag;
use App\HabitTag;
use App\Dotilog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        // Ajax request gives the requested UserField ID
        $uf = $request->input('userfield_id');
        // Now we gonna find all this UserField's habits
        if ($is_admin) {
            $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->get();
        } else {
            $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->where('active', 1)->get();
        }
        foreach ($habits as $habit) {
            $habit->getHabit->name;
        }
        $data = [
            "habits" => $habits
        ];
        //Küsitakse userfield'i ajaxiga, Habiteid! Teeme nii        //return $habits->toJson();
        return view('ajax.habits', $data);
    }
    // Trackimise lehel dropdown valides tuleb ajax req siia et saada habitite nimed
    public function ajaxTrackerGetFieldHabits(Request $request)
    {
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        // Ajax request gives the requested UserField ID
        $uf = $request->input('userfield_id');
        
        // Now we gonna find all this UserField's habits
        if ($is_admin) {
            $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->get();
        } else {
            $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->where('active', 1)->get();
        }
        
        //$names = "";
        $data = "";
        
        foreach ($habits as $habit) {
            $habit->getHabit->name;
            $data .= "<option value='" . $habit->id . "'>" . $habit->getHabit->name . "</option>";
        }
        return $data;
        //return view('ajax.habits', $data);
    }
    // Reflectimisel saad valida, erineb ülemisest, sest näitab logide counti
    public function ajaxReflectorGetFieldHabits(Request $request)
    {
        $is_admin = ( User::where('id', Auth::id())->first()->privilege >= 8 );
        // Ajax request gives the requested UserField ID
        $uf = $request->input('userfield_id');
        
        // Now we gonna find all this UserField's habits
        if ($is_admin) {
            $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->get();
        } else {
            $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->where('active', 1)->get();
        }
        
        //$names = "";
        $data = "";
        
        foreach ($habits as $habit) {
            $habit->getHabit->name;
            $data .= "<option value='" . $habit->id . "'>" . $habit->getHabit->name . " ". count($habit->getLogs) ."logs</option>";
        }
        return $data;
        //return view('ajax.habits', $data);
    }
    // Trackimise lehel dropdown valides tuleb ajax req siia et saada habitite unitid
    public function ajaxTrackerGetFieldHabitUnit(Request $request)
    {
        
        // Ajax request gives the requested UserField ID
        $ufh = $request->input('fieldhabit_id');
        
        // Now we gonna find all this UserField's habits
        $habits = FHabit::where('id', $ufh)->first();

        return $habits->unit_name;
    }
    
    public function ajaxTrackerGetFieldHabitTags(Request $request)
    {
        //No tag returning for now.
        return '';
        
        $responseTagId = [];
        $responseTagName = [];
        $resp="";
        
        // Ajax request gives the requested UserField ID
        $ufh = $request->input('fieldhabit_id');
        
        // Now we gonna find all this UserField's habits
        $fhabit = FHabit::where('id', $ufh)->first();
        $habitTags = $fhabit->getHabitTags;     //attached to this Habit!!
        foreach($habitTags as $ht){
            $ht->getTag;
            
            //print_r($ht);
            $responseTagId[] = $ht->id;
            $responseTagName[] = $ht->getTag->name;
            //$response .= $ht->getTag->name;
        }
        
        $data = [
            "tag_ids" => $responseTagId,
            "tag_name" => $responseTagName
        ];
        
        //HTML for tags::
        foreach ($responseTagId as $i => $row){
            $resp .= $resp
                .'<div style="background-color:#2bf6b1;margin: 2px; padding: 2px; float: left;">
                    <input
                      style=" height: 14px;"
                              type="checkbox"
                              name="habit-tags[]"
                              value="' . $responseTagId[$i] . '">' . $responseTagName[$i]
                .'</div>';
        }
        
        return $resp;
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
