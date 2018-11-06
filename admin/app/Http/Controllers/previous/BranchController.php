<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Organization;
use App\Corporate;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        // $this->middleware('auth:corporate');
    }
    public function index()
    {
        $title = 'branch View';
        $getData = branch::with('organization')->get();
        return view('admin.branch.index',compact('title','getData'));
    }
    public function corporateIndex()
    {
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        if($corporate[0]->branch_id == null){
            $title = 'branch View';
            $getData = branch::with('organization')->where('org_id',$corporate[0]->org_id)->get();

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
        $title = 'branch Create';
        $create = 1;
        $organization = Organization::where('status',1)->get();
        return view('admin.branch.form',compact('title','create','organization'));
    }

    public function corporateCreate()
    {
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        if($corporate[0]->branch_id == null){
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

        $branch = new branch();
        $branch->name = $request->name;
        $branch->org_id = $request->org_id;
        $branch->location = $request->location;
        $branch->hq = $request->hq;
        $branch->booth = $request->booth;
        $branch->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('branch.index');
    }
    public function corporateStore(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $corporate = Corporate::where('id',Auth::user()->id)->get();

        $branch = new branch();
        $branch->name = $request->name;
        $branch->org_id = $corporate[0]->org_id;
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
    public function edit(branch $branch)
    {
        $data['title'] = 'branch Edit';
        $data['create'] = 0;
        $data['branch'] = branch::findOrFail($branch);
        $data['organization'] = Organization::where('status',1)->get();
        return view('admin.branch.form',$data);
    }
    public function corporateEdit(branch $id)
    {
        $data['title'] = 'branch Edit';
        $data['create'] = 0;
        $data['branch'] = branch::findOrFail($id);
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

        $branch = branch::findOrFail($id);
        $branch->name = $request->name;
        $branch->org_id = $request->org_id;
        $branch->location = $request->location;
        $branch->hq = $request->hq;
        $branch->booth = $request->booth;
        $branch->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('branch.index');
    }
    public function corporateUpdate($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $branch = branch::findOrFail($id);
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
        branch::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('branch.index');
    }
}
