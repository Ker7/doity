<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    
    //public function UFHabit()
    //{
    //    return $this->belongsToMany('App\FHabit')->withTimestamps();
    //}
    
    public function getHabitTag()
    {
        //return $this->belongsToMany('App\FHabit')->withTimestamps();
        return $this->belongsToMany('App\HabitTag', 'id', 'tag_id');
    }
}
