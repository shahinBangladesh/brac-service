<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserType extends Model
{
	public static function boot(){
		parent::boot();
		static::creating(function ($query) {
            if (Auth::check()) {
                $query->org_id = Auth::user()->org_id;
            }
        });
        /*static::updating(function ($query) {
            if (Auth::check()) {
                $query->updated_by = Auth::id();
            }
        });*/
	}
}
