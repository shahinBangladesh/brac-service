<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
	use SoftDeletes;
    public function assignto(){
//        return $this->belongsTo(Requests::class);
        return $this->hasMany(Assign::class,'AssignTo');
    }
    public function assignedby(){
//        return $this->belongsTo(Requests::class);
        return $this->hasMany(Assign::class,'AssignedBy');
    }
    
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->created_by = Auth::id();
            }
        });
        static::updating(function ($query) {
            if (Auth::check()) {
                $query->updated_by = Auth::id();
            }
        });
    }
}
