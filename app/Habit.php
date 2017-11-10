<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Tag as Tag;

class Habit extends Model
{
    protected $table = 'habits';
    
    /* Get all Habits
     *
     */
    public function getAllTags(){
        return Tag::all();
    }
    
}
