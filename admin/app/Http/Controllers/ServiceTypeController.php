<?php

namespace App\Http\Controllers;
use App\ServiceType;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Service Type View';
        $data['getData'] = ServiceType::where('org_id',Auth::user()->org_id)->get();

        return view('serviceType.index',$data);
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
        return view('serviceType.form',$data);
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
            'name' => 'required'
        ]);

        $serviceType = new ServiceType();
        $serviceType->name = $request->name;
        $serviceType->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('serviceType.index');
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
        return view('serviceType.form',$data);
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
        return redirect()->route('serviceType.index');
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
        return redirect()->route('serviceType.index');
    }
}
