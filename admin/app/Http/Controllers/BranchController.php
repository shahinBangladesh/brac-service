<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Organization;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    public function index()
    {
        if(Auth::user()->branch_id == 0){
            $title = 'branch View';
            $getData = Branch::where('org_id',Auth::user()->org_id)->get();

            return view('branch.index',compact('title','getData'));
        }else{
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->branch_id == 0){
            $title = 'branch Create';
            $create = 1;
            return view('branch.form',compact('title','create'));
        }else{
            return redirect()->route('dashboard');
        }
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

        $branch = new Branch();
        $branch->name = $request->name;
        $branch->org_id = Auth::user()->org_id;
        $branch->location = $request->location;
        $branch->hq = $request->hq;
        $branch->booth = $request->booth;
        $branch->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('branch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'branch Edit';
        $data['create'] = 0;
        $data['branch'] = Branch::findOrFail($id);
        $data['organization'] = Organization::where('status',1)->get();
        return view('branch.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $branch = Branch::findOrFail($id);
        $branch->name = $request->name;
        $branch->location = $request->location;
        $branch->hq = $request->hq;
        $branch->booth = $request->booth;
        $branch->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Branch::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('branch.index');
    }
}
