<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateApprover extends Model
{
	protected $table = "estimate_approves";
	public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}	
	public function forwardUser(){
		return $this->belongsTo('App\User','forward_user_id','id');
	}	
	public function asset(){
		return $this->belongsTo('App\Asset','asset_id','id');
	}	
	public function branch(){
		return $this->belongsTo('App\Branch','branch_id','id');
	}	
}
