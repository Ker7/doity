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
        $habitTags = $fhabit->getHabitTags;
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
            $resp = $resp
                .'<div style="background-color:#2bf6b1;margin: 2px; padding: 2px;"><input style="height: 14px;" type="checkbox" name="habit-tags[]" value="' . $responseTagId[$i] . '">' . $responseTagName[$i] . '</div><br>'
                //.'<p style="background-color:#2bf6b1;
                //            padding: 2px;
                //            padding-left: 24px;
                //            margin: 2px;
                //            display:inline-flex;
                //            float: left;">' . $responseTagName[$i] . '</p>'
                            ;
        }
        
        
        //$resp .= '<select multiple>';
        //foreach ($responseTagId as $i => $row){
        //    $resp .= '<option value="' . $responseTagId[$i] . ' . ">' . $responseTagName[$i] . '</option>';
        //}
        //$resp .= '</select>';
        
        //print_r($fhabit);
        //print_r($resp);
        
        //echo "123123";
        
        //
        //$res = array();
        //foreach($habitTags as $ht){
        //    $res[] = $ht->getTag->name;
        //}
        //
        ////return "123123123";
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
