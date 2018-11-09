<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
	public function serviceType(){
		return $this->belongsTo('App\ServiceType','service_type_id','id');
	}
	public function organization(){
		return $this->belongsTo('App\Organization','org_id','id');
	}
	public function branch(){
		return $this->belongsTo('App\Branch','branch_id','id');
	}
	public function lastApprove(){
        return $this->hasOne('App\AssetApprove','asset_id','id')->latest();
    }
}
