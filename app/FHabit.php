<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FHabit extends Model
{
    protected $table = 'userfield_habit';
    
    //public function getHabit(){
    //    return $this->belongsToMany
    //}
    
    /**
     * 
     */
    public function getUserField()
    {
        return $this->hasOne('App\UserField', 'id', 'userfield_id');
    }
    /**
     * 
     */
    public function getHabit()
    {
        return $this->hasOne('App\Habit', 'id', 'habit_id');
    }
    
    /**
     * Get the Dotilog model of this Habit
     */
    public function getLogs()
    {
        //return $this->hasMany('App\Dotilog', 'fieldhabit_id', 'id');
        return $this->hasMany('App\Dotilog', 'fieldhabit_id', 'id')->orderBy('date_log')->limit(30);
                    //->get();
    }
    
    public function getUnit()
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }
    
    public function getTags()
    {
        return $this->belongsToMany('App\Tag', 'id', 'unit_id');
    }
}
