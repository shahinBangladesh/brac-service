<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class CorporateUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'corporates';

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
        'password'
    ];

    public function userType(){
        return $this->belongsTo('App\CorporateUserType','corporate_user_Type_Id', 'id');
    }
    public function organization(){
        return $this->belongsTo('App\Organization','org_id', 'id');
    }
}
