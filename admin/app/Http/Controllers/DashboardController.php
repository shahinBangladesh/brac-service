<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Branch;
use App\JobRequest;
use App\Organization;
use App\Service;
use App\ServiceType;
use App\User;
use App\Status;
use App\UserType;
use App\Vendor;
use App\AllRequestStatus;
use App\VendorCompany;
use App\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Mail;
use Auth;

class DashboardController extends Controller
{
    public function index(){
    	$auth = Auth::user();
        $data['title'] = 'Dashboard';
        //Dashboard All Count
        $data['ess_schedule'] = JobRequest::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            $query->where('status_id',0);
                                                                            if($auth->branch_id <>'')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        $data['pending'] = JobRequest::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            $query->where('status_id',5);
                                                                            if($auth->branch_id <>'')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        $data['asset'] = Asset::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>'')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        $data['jobRequest'] = JobRequest::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>'')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        // Recent Request List
        $data['recentReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        // Recent Request List
        $data['allRequestWithStatus'] = JobRequest::with('serviceType','branch','asset','approver','allrequeststatuses')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->orderBy('id','DESC')->take(10)->get();
        $data['recentApproverReq'] = JobRequest::with('serviceType','branch','asset','approver')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','!=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        // Recent Request List
        $data['estimateReq'] = JobRequest::with('serviceType','branch','asset','estimate')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','=','0')->orderBy('id','DESC')->get();
        $data['estimateApproveReq'] = JobRequest::with('serviceType','branch','asset','estimateApprove')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','!=','0')->orderBy('id','DESC')->get();

        // Recent Asset List
        $data['assetReq'] = Asset::with('serviceType','branch')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->orderBy('id','DESC')->get();

        $data['assetApproverReq'] = Asset::with('serviceType','branch','lastApprove')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','!=','0')->orderBy('id','DESC')->get();
                                   
         // Request with Status List
        $data['reqStatus'] = JobRequest::with('serviceType','branch','asset','approver','requestStatusList','statusLast')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('status_id','!=',0)->where('completeReq','!=',1)->orderBy('id','DESC')->get();

        $data['inProcess'] = JobRequest::with('serviceType','branch','asset')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    $query->where('completeReq','!=',1);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })->count();

        // Complete Request
        $data['completeStatus'] = JobRequest::with('serviceType','branch','asset')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <>'')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('completeReq',1)->orderByDesc('id')->get();
        $allStatus = Status::all();
        $data['organizationName'] = Organization::find(auth()->user()->org_id);
        $data['allStatusData'] = array();
        foreach($allStatus as $value){
            $data['allStatusData'][$value->name] = $value->id;
        }

    	return view('dashboard',$data);
    }
}
