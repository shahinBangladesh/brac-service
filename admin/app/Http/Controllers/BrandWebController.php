<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BrandWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Brand View';
        $getData = Brand::all();
        return view('admin.brands.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Brand Create';
        $create = 1;
        return view('admin.brands.form',compact('title','create'));
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

        $Brand = new Brand();
        $Brand->Name = $request->name;
        $Brand->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('brand.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $Brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $Brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $Brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $Brand)
    {
        $data['title'] = 'Brand Edit';
        $data['create'] = 0;
        $data['brand'] = Brand::findOrFail($Brand);
        return view('admin.brands.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $Brand
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $Brand = Brand::findOrFail($id);
        $Brand->Name = $request->name;
        $Brand->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $Brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('brand.index');
    }
}
