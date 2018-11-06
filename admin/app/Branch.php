<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Branch extends Model
{
    protected $table='branches';

    public function organization(){
    	return $this->belongsTo('App\Organization','org_id', 'id');
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
