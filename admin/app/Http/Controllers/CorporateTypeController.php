<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use App\ServiceTypes;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CorporateTypeController extends Controller
{
    public function index()
    {
        $title = 'Type View';
        $getData = Type::all();
        return view('admin.type.index',compact('title','getData'));
    }
    public function corporateIndex()
    {
        $title = 'Service Type View';
        $getData = ServiceTypes::all();
        return view('serviceType.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Type Create';
        $create = 1;
        return view('admin.type.form',compact('title','create'));
    }
    public function corporateCreate()
    {
        $title = 'Service Type Create';
        $create = 1;
        return view('serviceType.form',compact('title','create'));
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
            'serial' => 'required'
        ]);

        $payment = new Type();
        $payment->name = $request->name;
        $payment->serial = $request->serial;
        $payment->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('corporateType.index');
    }
    public function corporateStore(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $serviceType = new ServiceTypes();
        $serviceType->name = $request->name;
        $serviceType->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('serviceType.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(CorporateUserType $CorporateUserType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserType  $UserType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'UserType Edit';
        $data['create'] = 0;
        $data['userType'] = CorporateUserType::findOrFail($id);
        return view('admin.corporateUserType.form',$data);
    }
    public function corporateEdit($id)
    {
        $data['title'] = 'Service Type Edit';
        $data['create'] = 0;
        $data['serviceType'] = serviceTypes::findOrFail($id);
        return view('serviceType.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $UserType = CorporateUserType::findOrFail($id);
        $UserType->name = $request->name;
        $UserType->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('user_role.index');
    }
    public function corporateUpdate($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $UserType = ServiceTypes::findOrFail($id);
        $UserType->name = $request->name;
        $UserType->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('serviceType.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CorporateUserType::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('user_role.index');
    }
    public function corporateDestroy($id)
    {
        serviceTypes::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('serviceType.index');
    }
}
