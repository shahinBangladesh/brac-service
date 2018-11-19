<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VendorService extends Model
{
    protected $table = 'vendor_services';

    public function vendorCompany(){
    	return $this->belongsTo('App\VendorCompany','vendor_compnay_id','id');
    }

    public static function boot(){
        parent::boot();
        static::creating(function ($query) {
            if (Auth::check()) {
                $query->org_id = Auth::user()->org_id;
            }
        });
    }
}
