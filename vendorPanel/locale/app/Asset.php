<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
	public function type(){
		return $this->belongsTo('App\Type','type_id','id');
	}
	public function organization(){
		return $this->belongsTo('App\Organization','org_id','id');
	}
	public function branch(){
		return $this->belongsTo('App\Branch','branch_id','id');
	}
	public function lastApprove(){
        return $this->hasOne('App\AssetApprover','asset_id','id')->latest();
    }
}
