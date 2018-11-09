<?php

namespace App\Http\Controllers;
use App\ServiceType;
use App\Service;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Service Type View';
        $data['getData'] = Service::where('org_id',Auth::user()->org_id)->get();

        return view('service.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']= 'Service Type Create';
        $data['create'] = 1;
        $data['serviceType'] = ServiceType::where('org_id',Auth::user()->org_id)->pluck('name','id');
        return view('service.form',$data);
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
            'service_type_id' => 'required',
            'name' => 'required',
            'base_price' => 'required'
        ]);

        $service = new Service();
        $service->service_type_id = $request->service_type_id;
        $service->name = $request->name;
        $service->base_price = $request->base_price;
        $service->description = $request->description;
        $service->service_tex = $request->service_tex;
        $service->warranty = $request->warranty;
        $service->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('service.index');
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
        $data['title'] = 'Service Type Edit';
        $data['create'] = 0;
        $data['serviceType'] = ServiceType::findOrFail($id);
        return view('service.form',$data);
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
            'name' => 'required'
        ]);

        $UserType = ServiceType::findOrFail($id);
        $UserType->name = $request->name;
        $UserType->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceType::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('service.index');
    }
}
