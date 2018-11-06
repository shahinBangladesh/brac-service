<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\Corporate;
use App\Type;
use App\Organization;
use App\Branch;
use App\AssetApprover;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CorporateAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Asset View';
        $getData = Asset::with('type')->with('organization')->with('branch')->get();
        return view('admin.asset.index',compact('title','getData'));
    }
    public function corporateIndex()
    {
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        $title = 'Asset View';
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        $getData = Asset::where(function($query) use ($corporate){
                                                                $query->where('org_id',$corporate[0]->org_id);
                                                                $query->where('approveOrNot',1);
                                                                if($corporate[0]->branch_id <>'')
                                                                    $query->where('branch_id',$corporate[0]->branch_id);
                                                                })->get();
        return view('asset.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Asset Create';
        $data['create'] = 1;
        $data['type'] = Type::all();
        $data['organization'] = Organization::all();
        $data['branch'] = Branch::all();
        return view('admin.asset.form')->with($data);
    }
    public function corporateCreate()
    {
        $data['title'] = 'Asset Create';
        $data['create'] = 1;
        $data['type'] = Type::all();
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        $data['branch'] = Branch::where(function($query) use ($corporate){
                                                                            $query->where('org_id',$corporate[0]->org_id);
                                                                            if($corporate[0]->branch_id <>'')
                                                                                $query->where('id',$corporate[0]->branch_id);
                                                                            })->get();
        return view('asset.form')->with($data);
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

        $asset = new Asset();
        $asset->name = $request->name;
        $asset->location = $request->location;
        $asset->floor = $request->floor;
        $asset->type_id = $request->type_id;
        $asset->model = $request->model;
        $asset->capacity = $request->capacity;
        $asset->org_id = $request->org_id;
        $asset->branch_id = $request->branch_id;
        $asset->barrier = $request->barrier;
        $asset->remarks = $request->remarks;
        $asset->age = $request->age;
        $asset->remains = $request->remains;
        $asset->warrenty = $request->warrenty;
        $asset->expected_lifetime = $request->expected_lifetime;
        $asset->costing = $request->costing;
        $asset->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('asset.index');
    }
    public function corporateStore(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $corporate = Corporate::where('id',Auth::user()->id)->get();

        $asset = new Asset();
        $asset->brand = $request->brand;
        $asset->serial_no = $request->serial_no;
        // $asset->asset_no = $request->asset_no;
        $asset->vendor_showroom = $request->vendor_showroom;
        $asset->purchase_date = $request->purchase_date;
        $asset->warrenty_period = $request->warrenty_period;
        $asset->name = $request->name;
        $asset->location = $request->location;
        $asset->floor = $request->floor;
        $asset->type_id = $request->type_id;
        $asset->model = $request->model;
        $asset->capacity = $request->capacity;
        $asset->org_id = $corporate[0]->org_id;
        $asset->branch_id = $request->branch_id;
        $asset->notification = 1;
        /*$asset->barrier = $request->barrier;
        $asset->remarks = $request->remarks;
        $asset->age = $request->age;
        $asset->remains = $request->remains;
        $asset->warrenty = $request->warrenty;
        $asset->expected_lifetime = $request->expected_lifetime;
        $asset->costing = $request->costing;*/
        $asset->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('asset.index');
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
    public function edit(asset $asset)
    {
        $data['title'] = 'Asset Edit';
        $data['create'] = 0;
        $data['type'] = Type::all();
        $data['organization'] = Organization::all();
        $data['asset'] = Asset::findOrFail($asset);
        $data['branch'] = Branch::all();
        return view('admin.asset.form')->with($data);
    }
    public function corporateEdit($id)
    {
        $data['title'] = 'Asset Edit';
        $data['create'] = 0;
        $data['type'] = Type::all();
        $data['asset'] = Asset::findOrFail($id);
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        $data['branch'] = Branch::where('org_id',$corporate[0]->org_id)->get();
        
        return view('asset.form')->with($data);
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

        $asset = Asset::findOrFail($id);
        $asset->name = $request->name;
        $asset->location = $request->location;
        $asset->floor = $request->floor;
        $asset->type_id = $request->type_id;
        $asset->model = $request->model;
        $asset->capacity = $request->capacity;
        $asset->org_id = $request->org_id;
        $asset->branch_id = $request->branch_id;
        $asset->barrier = $request->barrier;
        $asset->remarks = $request->remarks;
        $asset->age = $request->age;
        $asset->remains = $request->remains;
        $asset->warrenty = $request->warrenty;
        $asset->expected_lifetime = $request->expected_lifetime;
        $asset->costing = $request->costing;
        $asset->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('asset.index');
    }
    public function corporateUpdate($id,Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $corporate = Corporate::where('id',Auth::user()->id)->get();
        $asset = Asset::findOrFail($id);
        $asset->brand = $request->brand;
        $asset->serial_no = $request->serial_no;
        // $asset->asset_no = $request->asset_no;
        $asset->vendor_showroom = $request->vendor_showroom;
        $asset->purchase_date = $request->purchase_date;
        $asset->warrenty_period = $request->warrenty_period;
        $asset->name = $request->name;
        $asset->location = $request->location;
        $asset->floor = $request->floor;
        $asset->type_id = $request->type_id;
        $asset->model = $request->model;
        $asset->capacity = $request->capacity;
        $asset->org_id = $corporate[0]->org_id;
        $asset->branch_id = $request->branch_id;
        /*$asset->barrier = $request->barrier;
        $asset->remarks = $request->remarks;
        $asset->age = $request->age;
        $asset->remains = $request->remains;
        $asset->warrenty = $request->warrenty;
        $asset->expected_lifetime = $request->expected_lifetime;
        $asset->costing = $request->costing;*/
        
        $asset->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('asset.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Asset::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('asset.index');
    }
    public function corporateDestroy($id)
    {
        Asset::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('asset.index');
    }
    public function assetListFromBranchId(Request $request){
        $assetList = Asset::where('branch_id',$request->branchId)->where('approveOrNot',1)->get();
        $asset = '<option value="">Choose a Asset</option>';
        foreach($assetList as $value){
            $asset .= '<option value="'.$value->id.'">'.$value->name.'('.$value->location.')'.'</option>';
        }
        return $asset;
    }

    public function approve($id){
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        if($corporate[0]->branch_id == null){
            $data['approverList'] = Corporate::where('approverOrConsent',1)->where('id','!=',Auth::guard('corporate')->user()->id)->get();
            $data['assetDetails'] = Asset::with('type','branch')->where('org_id',$corporate[0]->org_id)->where('id',$id)->get();

            $data['approveList'] = AssetApprover::with('corporateUser','asset','corporateForwardUser')->where('asset_id',$id)->get();
            $data['accessOrNot'] = AssetApprover::where('asset_id',$id)->count();
            if($data['accessOrNot']!=0){
                $approvePath = AssetApprover::where('asset_id',$id)->orderBy('id','DESC')->first();
                $data['approverAccessOrNot'] = AssetApprover::where('forward_user',Auth::guard('corporate')->user()->id)->where('id',$approvePath->id)->count();
            }
            return view('assetAction',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function notificationDetails($id){
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        if($corporate[0]->branch_id == null){
            $data['approverList'] = Corporate::where('approverOrConsent',1)->where('id','!=',Auth::guard('corporate')->user()->id)->get();
            $data['assetDetails'] = Asset::with('type','branch')->where('org_id',$corporate[0]->org_id)->where('id',$id)->get();

            $data['approveList'] = AssetApprover::with('corporateUser','asset','corporateForwardUser')->where('asset_id',$id)->get();
            $data['accessOrNot'] = AssetApprover::where('asset_id',$id)->count();
            if($data['accessOrNot']!=0){
                $approvePath = AssetApprover::where('asset_id',$id)->orderBy('id','DESC')->first();
                $data['approverAccessOrNot'] = AssetApprover::where('forward_user',Auth::guard('corporate')->user()->id)->where('id',$approvePath->id)->count();
            }
            return view('assetAction',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function assetApproved(Request $request){
        if($request->approves==2){
            $request->validate([
                'captcha' => 'required|captcha'
            ]);
        }
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        
        if($corporate[0]->branch_id == null){
            $asset = Asset::findOrFail($request->id);
            $assetApprover = new AssetApprover();
            $assetApprover->asset_id = $asset->id;
            $assetApprover->corporate_user_id = Auth::user()->id;
            $assetApprover->approver_status = $request->approves;
            if($request->forward_user != 0)
                $assetApprover->forward_user = $request->forward_user;
            $assetApprover->remarks = $request->remarks;
            $assetApprover->save();


            $asset->approveOrNot = $request->approves;
            $asset->notification = 3;
            $asset->save();

            return back();
        }else{
            return redirect()->route('dashboard');
        }
    }
}
