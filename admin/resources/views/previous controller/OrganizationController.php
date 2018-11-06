<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'organization View';
        $getData = Organization::all();
        return view('admin.organization.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'organization Create';
        $create = 1;
        return view('admin.organization.form',compact('title','create'));
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

        $organization = new organization();
        $organization->name = $request->name;
        $organization->status = $request->status;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/organization';
            $organization->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$organization->photo);
        }   
        $organization->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('organization.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(organization $organization)
    {
        $data['title'] = 'organization Edit';
        $data['create'] = 0;
        $data['organization'] = Organization::findOrFail($organization);
        return view('admin.organization.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $organization = Organization::findOrFail($id);
        $organization->name = $request->name;
        $organization->status = $request->status;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/organization';
            $organization->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$organization->photo);
        }   
        $organization->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('organization.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Organization::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('organization.index');
    }
}
