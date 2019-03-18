<?php
namespace App\Http\Traits;


use App\User as User;
use App\Field as Field;
use App\UserField as UserField;
use App\Habit as Habit;
use App\Dotilog as Dotilog;
use App\FHabit as FHabit;

trait BinderTrait {

    public function addUserField($uid, $fid) {
//echo "addUserField($uid, $fid) ";
        $userField = new UserField;
        $userField->user_id = $uid;
        $userField->field_id = $fid;
        $userField->save();
        return ;
    }
    /*
     *
     * @var
     */
    public function addFieldHabit($ufid, $hid, $unit_id = 1, $unit_name = 'unit', $comment = ''){
//echo "$ufid, $hid, $unit_name = 'unit', $comment = ''";
        $newFHabit = new FHabit;
        $newFHabit->userfield_id = $ufid;
        $newFHabit->habit_id = $hid;
        $newFHabit->internal = 0;
        $newFHabit->unit_id = $unit_id;                // 1 - placeholder for decimal! 2-time, 3-percentage
        $newFHabit->unit_name = $unit_name;
        $newFHabit->active = 1;
        $newFHabit->public = 0;
        $newFHabit->comment = $comment;
        $newFHabit->save();
    }
    
    public function sayIt(){
        echo "Tere!";
    }
    
}