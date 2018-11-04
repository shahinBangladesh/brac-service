<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobService extends Model
{
	protected $table='job_services';

	public function service(){
        return $this->belongsTo('App\Service','service_id','id');
    }
    public function job(){
        return $this->belongsTo('App\JobRequest','job_request_id','id');
    }
}
