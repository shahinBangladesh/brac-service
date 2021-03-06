<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetApprover extends Model
{
    protected $table = 'asset_approves';

    public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}	
	public function forward_user(){
		return $this->belongsTo('App\User','forward_user_id','id');
	}	
	public function asset(){
		return $this->belongsTo('App\Asset','asset_id','id');
	}	
}
