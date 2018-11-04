<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\ServicesCategory;

class WebController extends Controller
{
    public $services;
    public function __construct(){
        $this->services = Service::all();
    }
    public function landingPage(){
        $data['services'] = $this->services;
        $data['ServicesCategory'] = ServicesCategory::all();
        return view('web.mainPage',$data);
    }
    public function home(){
        $data['services'] = $this->services;
        return view('web.index',$data);
    }
    public function about(){
        $data['services'] = $this->services;
        return view('web.about-us',$data);
    }
    public function contact(){
        $data['services'] = $this->services;
        return view('web.contact-us',$data);
    }
    public function services(){
        $data['services'] = $this->services;
        return view('web.services',$data);
    }
    public function search(Request $request){
        $data['services'] = $this->services;
        return view('web.404',$data);
    }
}
