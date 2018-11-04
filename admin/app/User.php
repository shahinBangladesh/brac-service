<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    protected $dates=['deleted_at'];

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

    public function userType(){
        return $this->belongsTo('App\UserType','user_Type_Id', 'id');
    }
    public function createdBy(){
        return $this->belongsTo('App\User','created_by', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->created_by = Auth::id();
            }
        });
        static::updating(function ($query) {
            if (Auth::check()) {
                $query->updated_by = Auth::id();
            }
        });
    }
}
