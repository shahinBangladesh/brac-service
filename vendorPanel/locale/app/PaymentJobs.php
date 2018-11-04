<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentJobs extends Model
{
    protected $table='payment_jobs'; 
    public function job(){
        return $this->belongsTo('App\JobRequest','job_request_id','id');
    }
}
