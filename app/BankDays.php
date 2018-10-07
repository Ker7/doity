<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankValues extends Model
{
    protected $table = 'bank_values';
    //
    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
