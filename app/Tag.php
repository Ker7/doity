<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    
    public function UFHabit()
    {
        return $this->belongsToMany('App\FHabit')->withTimestamps();
    }
}
