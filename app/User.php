<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Field as Field;
use App\UserField as UserField;
use App\Habit as Habit;
use App\FHabit as FHabit;
use App\Dotilog as Dotilog;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
        
    /**
     * The table associated with the model. Snake case - plural name for table is assumes.
     * So in this case it is not important whether we do declare this table or not.
     *
     * @var string
     */
    protected $table = 'users';
    
    protected   $userFields,
                $userFieldHabits;
    
    /**
     * Method for calling fields created by self.
     */
    public function getAuthoredFields() {
        return $this->hasMany('App\Field', 'author_user');
        //return "yoyo";
    }
        
    /**
     * Method for calling fields linked to the self, aka The User
     */
    public function getLinkedUserFields() {
        return $this->hasMany('App\UserField');
        //return "yoyo";
    }
    
    /*
     * @return array Field models linked to self user via UserField entities
     */
    public function getLinkedFields() {
        $this->userFields = $this->getLinkedUserFields;     // Need UserFields for this, possible to fill this variable when calling in the first place? @@idea
        $fields_array = array();
        foreach ($this->userFields as $user_fields) {
            $fields_array[] = $user_fields->getField;
        }
        return $fields_array; 
    }
    
    /*
     * @return array FHabit models linked to self user via UserField entities
     */
    public function getLinkedUserFieldHabits() {
        $this->userFields = $this->getLinkedUserFields;     // Need UserFields for this, possible to fill this variable when calling in the first place? @@idea
        $fhabits_array = array();
        foreach ($this->userFields as $user_fields) {
            //$fhabits_array[] = FHabit::where('userfield_id', $user_fields->id)->get();        //One way, but Model already has the Method!
            $fhabits_array[] = $user_fields->getFieldHabits;
            
            //echo $user_fields->id . ' - ' . $user_fields->getField->name . ', ';
            //print_r($user_fields->getFieldHabits);
        }
        return $fhabits_array; 
    }
    
    /* Validation required! @todo
     *
     */
    public function setName($newName){
        $this->name = $newName;
        $this->save();
    }
}
