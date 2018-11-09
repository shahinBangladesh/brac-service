<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
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
    public function organization(){
    	return $this->belongsTo('App\Organization','org_id','id');
    }
    public function status(){
    	return $this->belongsTo('App\Status','status_id','id');
    } 
}
