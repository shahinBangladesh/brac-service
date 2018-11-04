<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateApprover extends Model
{
	protected $table = "estimate_approves";
	public function corporateUser(){
		return $this->belongsTo('App\Corporate','corporate_user_id','id');
	}	
	public function corporateForwardUser(){
		return $this->belongsTo('App\Corporate','forward_user','id');
	}	
	public function asset(){
		return $this->belongsTo('App\Asset','asset_id','id');
	}	
	public function branch(){
		return $this->belongsTo('App\Branch','branch_id','id');
	}	
}
