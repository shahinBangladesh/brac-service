<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\User;
use App\ServiceType;
use App\Organization;
use App\Branch;
use App\AssetApprove;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Asset View';
        $auth = Auth::user();
        $data['getData'] = Asset::where(function($query) use ($auth){
                                                                $query->where('org_id',$auth->org_id);
                                                                $query->where('approveOrNot',1);
                                                                if($auth->branch_id != 0)
                                                                    $query->where('branch_id',$auth->branch_id);
                                                                })->get();
        return view('asset.index',$data);
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
        $auth = Auth::user();
        $data['type'] = ServiceType::where('org_id',$auth->org_id)->pluck('name','id');
        $data['branch'] = Branch::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>'')
                                                                                $query->where('id',$auth->branch_id);
                                                                            })->pluck('name','id');
        
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
        $asset->brand = $request->brand;
        $asset->serial_no = $request->serial_no;
        $asset->vendor_showroom = $request->vendor_showroom;
        $asset->purchase_date = $request->purchase_date;
        $asset->warrenty_period = $request->warrenty_period;
        $asset->name = $request->name;
        $asset->location = $request->location;
        $asset->floor = $request->floor;
        $asset->service_type_id = $request->type_id;
        $asset->model = $request->model;
        $asset->capacity = $request->capacity;
        $asset->org_id = Auth::user()->org_id;
        $asset->branch_id = $request->branch_id;
        $asset->notification = 1;
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
    public function edit($id)
    {
        $data['title'] = 'Asset Edit';
        $data['create'] = 0;
        $auth = Auth::user();
        $data['type'] = ServiceType::where('org_id',$auth->org_id)->pluck('name','id');
        $data['branch'] = Branch::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>'')
                                                                                $query->where('id',$auth->branch_id);
                                                                            })->pluck('name','id');
        $data['asset'] = Asset::findOrFail($id);
        
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
        $asset->brand = $request->brand;
        $asset->serial_no = $request->serial_no;
        $asset->vendor_showroom = $request->vendor_showroom;
        $asset->purchase_date = $request->purchase_date;
        $asset->warrenty_period = $request->warrenty_period;
        $asset->name = $request->name;
        $asset->location = $request->location;
        $asset->floor = $request->floor;
        $asset->service_type_id = $request->type_id;
        $asset->model = $request->model;
        $asset->capacity = $request->capacity;
        $asset->org_id = Auth::user()->org_id;
        $asset->branch_id = $request->branch_id;
        $asset->save();
        
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
    public function assetListFromBranchId(Request $request){
        $assetList = Asset::where('branch_id',$request->branchId)->where('approveOrNot',1)->get();
        $asset = '<option value="">Choose a Asset</option>';
        foreach($assetList as $value){
            $asset .= '<option value="'.$value->id.'">'.$value->name.'('.$value->location.')'.'</option>';
        }
        return $asset;
    }

    public function approve($id){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
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
        if(Auth::user()->branch_id == null){
            $data['approverList'] = User::where('approverOrConsent',1)->where('id','!=',Auth::user()->id)->get();
            $data['assetDetails'] = Asset::with('serviceType','branch')->where('org_id',Auth::user()->org_id)->where('id',$id)->get();

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
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        
        if($corporate[0]->branch_id == null){
            $asset = Asset::findOrFail($request->id);
            $assetApprover = new AssetApprover();
            $assetApprover->asset_id = $asset->id;
            $assetApprover->corporate_user_id = Auth::guard('corporate')->id();
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
