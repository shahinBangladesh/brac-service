<?php

namespace App\Http\Controllers\vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class VendorController extends Controller
{
	public function __construct(){
        $this->middleware('auth:vendorPanel');
	}
    public function index(){
        $data['title'] = 'Dashboard';
    	return view('vendors.dashboard',$data);
    }
}
