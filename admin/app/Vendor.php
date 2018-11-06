<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
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
