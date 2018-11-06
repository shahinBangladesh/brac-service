<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'status View';
        $getData = Status::all();

        /*$parentService = array();
        foreach($getData as $value){
            $parentService[] = $value->
        }*/
        return view('admin.status.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'status Create';
        $create = 1;
        return view('admin.status.form',compact('title','create'));
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

        $status = new status();
        $status->name = $request->name;
        $status->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('status.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(status $status)
    {
        $data['title'] = 'status Edit';
        $data['create'] = 0;
        $data['status'] = Status::findOrFail($status);
        return view('admin.status.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\status  $status
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $status = Status::findOrFail($id);
        $status->name = $request->name;
        $status->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('status.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Status::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('status.index');
    }
}
