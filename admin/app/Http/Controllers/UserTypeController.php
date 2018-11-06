<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserTypeController extends Controller
{
    public function index()
    {
        $title = 'Corporate User Type View';
        $getData = UserType::where('org_id',Auth::user()->org_id)->get();
        return view('user-type.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Corporate User Type Create';
        $create = 1;
        return view('user-type.form',compact('title','create'));
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

        $payment = new UserType();
        $payment->name = $request->name;
        $payment->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('user-type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(UserType $UserType)
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
        $data['userType'] = UserType::findOrFail($id);
        return view('user-type.form',$data);
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

        $UserType = UserType::findOrFail($id);
        $UserType->name = $request->name;
        $UserType->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('user-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserType::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('user-type.index');
    }
}
