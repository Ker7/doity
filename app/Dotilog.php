<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dotilog extends Model
{
    protected $table = 'dotilogs';
    
    protected $fillable = [
        'date_log', 'time_log',
    ];
    
}
