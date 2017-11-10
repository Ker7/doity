<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HabitTag extends Model
{
    protected $table = 'fhabit_tag';
    
    
    public function getHabit()
    {
        return $this->belongsToMany('App\FHabit', 'id', 'fieldhabit_id');
    }
    
    public function getTag()
    {
        return $this->hasOne('App\Tag', 'id', 'tag_id', 'fhabit_tag');
    }
    //
}
