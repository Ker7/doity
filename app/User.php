<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    
    /**
     * Method for calling fields created by self.
     *
     */
    public function getAuthoredFields() {
        return $this->hasMany('App\Field', 'author_user');
        //return "yoyo";
    }
        
    /**
     * Method for calling fields created by self WITH OneToMany!!! for getting info from 
     * One-Many-One nüüd!!!
     */
    public function getLinkedUserFields() {
        return $this->hasMany('App\UserField');
        //return "yoyo";
    }
    
    /* Validation required! @todo
     *
     */
    public function setName($newName){
        $this->name = $newName;
        $this->save();
    }
}
