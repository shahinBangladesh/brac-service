<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Service extends Model
{
    public function serviceType(){
    	return $this->belongsTo('App\ServiceType','service_type_id','id');
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
