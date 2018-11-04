<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    public function parentService(){
    	// return $this->belongsTo('App\Service','parent_id','id');
    }
}
