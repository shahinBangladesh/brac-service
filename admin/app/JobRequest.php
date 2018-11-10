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
    public function approver(){
        return $this->belongsTo('App\ApproverPath','id','req_id')->latest();
    }
    public function allrequeststatuses(){
         return $this->hasMany('App\AllRequestStatus','job_request_id','id');
    }
    public function estimate(){
        return $this->hasOne('App\Estimate','job_request_id','id');
    }
    public function estimateApprove(){
        return $this->hasOne('App\EstimateApprover','job_request_id','id')->latest();
    }
    public function estimateReject(){
        return $this->hasOne('App\EstimateApprover','job_request_id','id')->where('approver_status',2);
    }
    public function requestStatusList(){
        return $this->hasMany('App\AllRequestStatus','job_request_id','id');
    }
    public function statusLast(){
        return $this->belongsTo('App\Status','status_id');
    }
}
