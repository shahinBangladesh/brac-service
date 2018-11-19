<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Vendor extends Authenticatable
{
    use Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'name', 'email', 'password'
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
		return $this->belongsTo('App\VendorUserType','vendor_user_type_id','id');
	}

    public static function boot(){
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->org_id = Auth::user()->org_id;
            }
        });
    }
}
