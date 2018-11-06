<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class VendorCompany extends Model
{
    protected $table = 'vendors_companies';

    public static function boot(){
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->org_id = Auth::user()->org_id;
            }
        });
    }
}
