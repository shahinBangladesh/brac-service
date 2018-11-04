<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table='branches';

    public function organization(){
    	return $this->belongsTo('App\Organization','org_id', 'id');
    }
}
