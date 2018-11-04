<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\JobRequest;
use App\User;
use App\RequestStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assign extends Model
{
    use SoftDeletes;

    public function request(){
//        return $this->belongsTo(Requests::class);
        return $this->belongsTo(JobRequest::class,'job_request_id','id'); 
//JobRequest er "id" Assign table er kon column use korse tar name.... structure is JobRequest, assign er foreign key,JobRequest er primary key
    }
    public function assignto(){
        return $this->belongsTo(User::class,'AssignTo'); // base model foreign key
    }
    public function assignedby(){
        return $this->belongsTo(User::class,'AssignedBy');// base model foreign key
    }
    public function assign(){
        return $this->belongsTo(User::class,'job_request_id');// base model foreign key
    }
    public function RequestStatus(){
        return $this->hasOne(RequestStatus::class,'AssignID','id'); // clsss,this class id, base model id
    }
}
