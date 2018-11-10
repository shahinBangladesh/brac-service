<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Auth;

class JobCart extends Model
{
    public function serviceType(){
    	return $this->belongsTo('App\ServiceType','service_type_id','id');
    }
    public function branch(){
    	return $this->belongsTo('App\Branch','branch_id','id');
    }
    public function asset(){
    	return $this->belongsTo('App\Asset','asset_id','id');
    }

     public static function boot(){
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->created_by = Auth::user()->id;
            }
        });
    }
}
