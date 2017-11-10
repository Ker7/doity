<?php

namespace App\Http\Controllers;

use App\UserField;
use App\FHabit;
use App\Tag;
use App\HabitTag;
use App\Dotilog;
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
        foreach ($habits as $habit) {
            $habit->getHabit->name;
            //$habit->uusVaartus = 'jouu'; //This way I can add new values
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
        // Ajax request gives the requested UserField ID
        $uf = $request->input('userfield_id');
        
        // Now we gonna find all this UserField's habits
        $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->get();
        
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
        // Ajax request gives the requested UserField ID
        $uf = $request->input('userfield_id');
        
        // Now we gonna find all this UserField's habits
        $habits = FHabit::where('userfield_id', $uf)->where('internal', 0)->get();
        
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
        
        //$hhabit = $fhabit->getHabit;
        //print_r( Tag::all() );
        
        foreach(Tag::all() as $tag){
            //echo $tag->name;
        }
        
        //echo $resp;
        
        // GET ALL TAGS
        //foreach (Tag::all() as $tag){
            //echo '<div style="background-color:#2bf6b1;margin: 2px; padding: 2px; float: left;">
            //        <input
            //          style=" height: 14px;"
            //                  type="checkbox"
            //                  name="habit-tags[]"
            //                  value="' . $tag->id . '">' . $tag->name
            //    .'</div>';
//echo $tag->id . ' - '.$tag->name .'<br />';
        //}
        // GET ALL 
        
        $habtags = HabitTag::where('fieldhabit_id', $request->input('fieldhabit_id'))->get();
        
        //print_r($habtags);
        //echo '</ br>';
        
        foreach ( $habtags as $htg) {
            $htg->getHabit;
            print_r($htg);
            //echo $htg->id . ' - '.$htg->getHabit->name .'<br />';
        }
        
        return;
        //$logs = Dotilog::all();
        //
        //foreach($logs as $l) {
        //    echo $l->id;
        //}
        
        //return $resp;
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
