<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class AssetApprove extends Model
{
	public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}	
	public function forwardUser(){
		return $this->belongsTo('App\User','forward_user','id');
	}	
	public function asset(){
		return $this->belongsTo('App\Asset','asset_id','id');
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
