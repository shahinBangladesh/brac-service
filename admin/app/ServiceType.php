<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Auth;

class ServiceType extends Model
{
    public static function boot(){
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->org_id = Auth::user()->org_id;
                $query->created_by = Auth::user()->id;
            }
        });
    }
}
