<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserField extends Model
{
        
    /**
     * The table associated with the model. Snake case - plural name for table is assumes.
     * So in this case it is not important whether we do declare this table or not.
     *
     * @var string
     */
    protected $table = 'field_user';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clicked', 'active', 'public',
    ];
    
    protected $user;    
    protected $field;
    
    public function __construct(){
        //$this->user = $this->getUser;
        //$this->field = $this->getField;
    }
    
    /**
     * Get the Field model of this User-Field boundation
     */
    public function getField()
    {
        return $this->hasOne('App\Field', 'id', 'field_id');
    }
    /**
     * Get the Field model of this User-Field boundation
     */
    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    /* All habits linked to this User Field */
    public function getHabits()
    {
        return $this->hasMany('App\FHabits', 'userfield_id', 'id');
    }
    /* Get habits linked to this user with internal value */
    public function getInternalHabits()
    {
        $habs = $this->hasMany('App\FHabit', 'userfield_id', 'id')->where('internal', true);
                    //->orderBy('date_log', 'desc')
                    //->get();
        
        return $habs;
    
        //$habitsa = $this->getHabits()->where('internal', true)->get();
        //return $habitsa;
    }
    
    /* Get habits linked to this user with internal value */
    public function getFieldIHabits()
    {                                       // tegelt peaks olema siin mille habit on "_log"
        //return $this->hasMany('App\FHabits', 'userfield_id', 'id')->where('internal', '=', 1);
        $habitsb =  $this->hasMany('App\FHabit', 'userfield_id', 'id')->where('internal', '=', 1);
        //$habitsb = $this->getHabits()->getQuery()->orderBy('date_log', 'ASC')->get();
        return $habitsb;
    }
    public function getFieldHabits()
    {                                       // tegelt peaks olema siin mille habit on "_log"
        //return $this->hasMany('App\FHabits', 'userfield_id', 'id')->where('internal', '=', 1);
        $habitsb =  $this->hasMany('App\FHabit', 'userfield_id', 'id');
        //$habitsb = $this->getHabits()->getQuery()->orderBy('date_log', 'ASC')->get();
        return $habitsb;
    }
    
    // Ei oska niimoodi piirata päringut siinsama, peab vist kontrolleris
    //
    //public function getFieldLogHabit()
    //{
    //    //return $this->getHabits()->where('internal', 0)->whereHas('Profile', function($q){
    //    //    $q->where('gender', 'Male');
    //    //});
    //    //return $this->getHabits()->whereHas('Habit', function($q){
    //    //    $q->where('name', '_log');
    //    //})->get();
    //
    //    //return UserField::with('Habit')->where('internal', 1)->whereHas('Habit', function($q){
    //    //        $q->where('name', '_log');
    //    //    })->get();
    //    //return $this->getHabits()->where('habits.name', '=', 'Tarbi');
    //}
    
    // Testfunktsioon. @todo eemaldada
    public function toggleClicked() {
        $this->clicked = $this->clicked ? false : true;
        $this->save();
    }
    
    /* Toggle whether this Field is shown to others or not.
     * This is general default, which is used for Habits as well
     */
    public function toggleActive() {
        $this->active = $this->active ? false : true;
        $this->save();
    }
    public function togglePublic() {
        $this->public = $this->public ? false : true;
        $this->save();
    }
}
