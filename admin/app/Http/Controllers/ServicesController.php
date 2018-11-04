<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\ServicesCategory;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Service View';
        // $getData = Service::with('parentService')->get();
        $getData = Service::get();
        return view('admin.services.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Service Create';
        $data['create'] = 1;
        $data['serviceList'] = Service::where('parent_id','0')->get();
        $data['serviceCategoryList'] = ServicesCategory::all();
        return view('admin.services.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'photo'=>'image|mimes:jpg,jpeg,png'
        ]);

        $service = new Service();
        $service->servicesCategoryId = $request->servicesCategoryId;
        $service->parent_id = $request->parent_id;
        $service->name = $request->name;
        $service->base_price = $request->base_price;
        $service->description = $request->description;
        $service->includes = $request->includes;
        $service->service_tex = $request->service_tex;
        $service->service_text   = $request->service_text ;
        $service->tag   = $request->tag ;
        $service->warranty   = $request->warranty ;

        if ($request->hasFile('header_image')) {
            $file = $request->file('header_image');
            $destinationPath = 'image/servicePhoto';
            $service->header_image = $file->getClientOriginalName();
            $file->move($destinationPath,$service->header_image);
        }
        // dd($service);
        $service->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Service Edit';
        $data['create'] = 0;
        $data['service'] = Service::findOrFail($id);
        $data['serviceList'] = Service::where('parent_id','0')->get();
        $data['serviceCategoryList'] = ServicesCategory::all();
        return view('admin.services.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'photo'=>'image|mimes:jpg,jpeg,png'
        ]);

        $service = Service::findOrFail($id);
        $service->servicesCategoryId = $request->servicesCategoryId;
        $service->parent_id = $request->parent_id;
        $service->name = $request->name;
        $service->base_price = $request->base_price;
        $service->description = $request->description;
        $service->includes = $request->includes;
        $service->service_tex = $request->service_tex;
        $service->service_text   = $request->service_text ;
        $service->tag   = $request->tag ;
        $service->warranty   = $request->warranty ;

        if ($request->hasFile('header_image')) {
            $file = $request->file('header_image');
            $destinationPath = 'image/servicePhoto';
            $service->header_image = $file->getClientOriginalName();
            $file->move($destinationPath,$service->header_image);
        }
        $service->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('services.index');
    }
}
