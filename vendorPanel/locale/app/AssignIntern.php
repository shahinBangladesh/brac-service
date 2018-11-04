<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AssignIntern extends Model
{
    protected $table='assignintern';

    public function assignto(){
        return $this->belongsTo(User::class,'userId'); // base model foreign key
    }
}
