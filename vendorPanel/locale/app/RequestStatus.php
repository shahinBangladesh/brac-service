<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    public function assign(){
        return $this->belongsTo(Assign::class,'AssignID','id');
    }
    public function status(){
    	return $this->belongsTo('App\Status','Status','id');
    }
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
