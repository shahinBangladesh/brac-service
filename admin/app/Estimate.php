<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimate extends Model
{
	use SoftDeletes;
    public function JobRequest(){
        return $this->belongsTo(JobRequest::class,'job_request_id'); 
    }
    public function service(){
        return $this->belongsTo('App\Service','service_id','id'); 
    }

    protected $hidden = [
        'created_at', 'updated_at',
    ];
    
}
