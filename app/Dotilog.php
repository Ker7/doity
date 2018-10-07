<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dotilog extends Model
{
    protected $table = 'dotilogs';
    
    protected $fillable = [
        'date_log', 'time_log', 'date_log2', 'time_log2',
    ];
        
    public function getFieldHabit()
    {
        $habitsb =  $this->hasOne('App\FHabit', 'id' , 'fieldhabit_id');
        //$habitsb = $this->getHabits()->getQuery()->orderBy('date_log', 'ASC')->get();
        return $habitsb;
    }
    
}
