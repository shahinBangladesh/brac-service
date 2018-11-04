<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllRequestStatus extends Model
{
    protected $table = 'allrequeststatuses';
    public function status(){
    	return $this->belongsTo('App\Status','status_id','id');
    }
}
