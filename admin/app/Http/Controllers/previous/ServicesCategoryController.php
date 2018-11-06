<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServicesCategory;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ServicesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'ServicesCategory View';
        $getData = ServicesCategory::get();
        return view('admin.ServicesCategorys.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'ServicesCategory Create';
        $data['create'] = 1;
        return view('admin.ServicesCategorys.form',$data);
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

        $ServicesCategory = new ServicesCategory();
        $ServicesCategory->name = $request->name;
        $ServicesCategory->icon = $request->icon;
        $ServicesCategory->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('servicesCategory.index');
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
        $data['title'] = 'Services Category Edit';
        $data['create'] = 0;
        $data['service'] = ServicesCategory::findOrFail($id);
        return view('admin.ServicesCategorys.form',$data);
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

        $ServicesCategory = ServicesCategory::findOrFail($id);
        $ServicesCategory->name = $request->name;
        $ServicesCategory->icon = $request->icon;
        $ServicesCategory->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('servicesCategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServicesCategory::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('servicesCategory.index');
    }
}
