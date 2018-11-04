<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Assign;
use App\Brand;
use App\Status;
use App\Payment;

class JobRequest extends Model
{
    protected $table='job_requests';
    protected $dates = ['deleted_at'];
//     fillable is needed when update by api request
    protected $fillable=[
        'ServiceItem','ProblemDescription','DeviceQty','Brand','Phone','Address'
    ];
    public function assign(){
        return $this->hasOne(Assign::class,'job_request_id'); 
        // JobRequest(one) er primary key assign table a Onek bar (Many) ase "job_request_id" (foreign key) column hisabe
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'Brand'); // 'Brand' is foreign key inside JobRequest         
    }
    public function paymentMethod(){
        return $this->belongsTo(Payment::class,'PaymentMethod'); // 'PaymentMethod' is foreign key inside JobRequest         
    }

    public function billing(){
        return $this->hasMany(Billing::class,'job_request_id'); 
    }

    public function service(){
        return $this->hasOne('App\Service','id','ServiceItemId'); 
    }
    public function serviceType(){
        return $this->hasOne('App\ServiceTypes','id','serviceTypeId'); 
    }

    public function payment_jobs(){
        return $this->hasOne('App\PaymentJobs','job_request_id','id');
    }
    public function branch(){
        return $this->hasOne('App\Branch','id','branchId');
    }
    
    public function asset(){
        return $this->hasOne('App\Asset','id','assetId');
    }

    public function organization(){
        return $this->hasOne('App\Organization','id','org_id');
    }
    public function status(){
        return $this->hasOne('App\Status','id','status_id');
    }
    public function requestStatusList(){
        // return $this->belongsToMany('App\Status','request_statuses','jobId','Status');
        return $this->hasMany('App\RequestStatus','jobId','id');
    }
    public function jobServiceToServiceName(){
        return $this->belongsToMany('App\Service','job_services','job_request_id','service_id');
    }
    public function statusLast(){
        return $this->belongsTo('App\Status','status_id');
    }
    public function lastStatusFromAllRequestStaus(){
        return $this->hasOne('App\AllRequestStatus','req_id','id')->latest();
    }
    public function approver(){
        return $this->belongsTo('App\ApproverPath','id','req_id');
    }
    public function allrequeststatuses(){
         return $this->hasMany('App\AllRequestStatus','req_id','id');
         // return $this->belongsToMany('App\Status','allrequeststatuses','req_id','status_id');
    }
    public function estimate(){
        return $this->hasOne('App\Estimate','job_request_id','id');
    }
    public function estimateApprove(){
        return $this->hasOne('App\EstimateApprover','req_id','id')->latest();
    }
    public function estimateReject(){
        return $this->hasOne('App\EstimateApprover','req_id','id')->where('approver_status',2);
    }
    
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
