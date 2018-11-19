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
use App\ApproverPath;
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
                                                                            if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        $data['pending'] = JobRequest::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            $query->where('status_id',5);
                                                                            if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        $data['asset'] = Asset::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        $data['jobRequest'] = JobRequest::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->count();
        // Recent Request List
        $data['recentReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        // Recent Request List
        $data['allRequestWithStatus'] = JobRequest::with('serviceType','branch','asset','approver','allrequeststatuses')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->orderBy('id','DESC')->take(10)->get();
        $data['recentApproverReq'] = JobRequest::with('serviceType','branch','asset','approver')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','!=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        // Recent Request List
        $data['estimateReq'] = JobRequest::with('serviceType','branch','asset','estimate')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','=','0')->orderBy('id','DESC')->get();
        $data['estimateApproveReq'] = JobRequest::with('serviceType','branch','asset','estimateApprove')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','!=','0')->orderBy('id','DESC')->get();

        // Recent Asset List
        $data['assetReq'] = Asset::with('serviceType','branch')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->orderBy('id','DESC')->get();

        $data['assetApproverReq'] = Asset::with('serviceType','branch','lastApprove')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','!=','0')->orderBy('id','DESC')->get();
                                   
         // Request with Status List
        $data['reqStatus'] = JobRequest::with('serviceType','branch','asset','approver','requestStatusList','statusLast')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('status_id','!=',0)->where('completeReq','!=',1)->orderBy('id','DESC')->get();

        $data['inProcess'] = JobRequest::with('serviceType','branch','asset')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    $query->where('completeReq','!=',1);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })->count();

        // Complete Request
        $data['completeStatus'] = JobRequest::with('serviceType','branch','asset')->
                            where(function($query) use ($auth){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
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
    public function approveAction($jobReqId){
        $auth = Auth::user();
        if($auth->branch_id == 0){
            $jobDetails = JobRequest::with('serviceType','branch','asset')->where('org_id',$auth->org_id)->findOrFail($jobReqId);
            $data['approverList'] = User::where('approverOrConsent',1)->where('id','!=',$auth->id)->get();
            $data['jobDetails'] = $jobDetails;
            $data['approveList'] = ApproverPath::with('user','asset','branch','forwardUser')->where('req_id',$jobReqId)->get();
            $data['accessOrNot'] = ApproverPath::where('req_id',$jobReqId)->count();
            if($data['accessOrNot']!=0){
                $approvePath = ApproverPath::where('req_id',$jobReqId)->orderBy('id','DESC')->limit(1)->get();
                $data['approverAccessOrNot'] = ApproverPath::where('forward_user',$auth->id)->where('id',$approvePath[0]->id)->count();
            }
            $data['vendorCompaniesList'] = VendorService::with('vendorCompany')->where(['org_id'=>$auth->org_id,'service_type_id'=>$jobDetails->service_type_id])->groupBy('vendor_compnay_id')->get();
            
            return view('approveAction',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function reqApproved(request $request){
        $auth = Auth::user();

        if($request->approves==2){
            $this->validate($request, [
                'captcha' => 'required|captcha',
                'remarks' => 'required'
            ]);
        }
        
        if($auth->branch_id == 0){
            $jobReq = JobRequest::findOrFail($request->jobRequestId);
            $approverpaths = new ApproverPath();
            $approverpaths->req_id = $request->jobRequestId;
            $approverpaths->asset_id = $jobReq->assetId;
            $approverpaths->branch_id = $jobReq->branchId;
            $approverpaths->corporate_user_id = $auth->id;
            $approverpaths->approver_status = $request->approves;
            $approverpaths->forward_user = $request->forward_user;
            $approverpaths->remarks = $request->remarks;
            $approverpaths->amount = $request->amount;
            $approverpaths->expectedDate = $request->expectedDate;
            $approverpaths->save();

            JobRequest::where('id', $request->jobRequestId)
                  ->update(['approveOrNot' => $request->approves]);    

            if($request->approves==1){
                $allrequeststatuses = new AllRequestStatus();
                $allrequeststatuses->req_id = $request->jobRequestId;
                $allrequeststatuses->status_id = 12;
                $allrequeststatuses->notification = 1;
                $allrequeststatuses->corporate_notification = 1;
                $allrequeststatuses->save();
            }else if($request->approves==2){
                $allrequeststatuses = new AllRequestStatus();
                $allrequeststatuses->req_id = $request->jobRequestId;
                $allrequeststatuses->status_id = 6;
                $allrequeststatuses->notification = 1;
                $allrequeststatuses->corporate_notification = 1;
                $allrequeststatuses->save();
            }

            return redirect()->route('approved',$request->jobRequestId);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function report(){
        $auth = Auth::user();
        // if($auth->branch_id == 0){
            $data['branch'] = Branch::where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('id',$auth->branch_id);
                                                                    })->get();
            $data['asset'] = Asset::where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })->get();
            $data['serviceType'] = ServiceType::all();
            $data['requests'] = '';
            $data['jobRequest'] = '';
            return view('report',$data);
        /*}else{
            return redirect()->route('dashboard');
        }*/
    }
    public function getReport(request $request){
        $auth = Auth::user();
        $data['jobRequest'] = JobRequest::with('serviceType','branch','asset','status','statusLast')->where(function($query) use ($corporate,$request){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($request->branch != 0)
                                                                                $query->where('branch_id',$request->branch);
                                                                            if($request->asset != 0)
                                                                                $query->where('asset_id',$request->asset);
                                                                            if($request->serviceType != 0)
                                                                                $query->where('service_type_id',$request->serviceType);
                                                                            if($request->from <> '')
                                                                                $query->where('created_at','>=',$request->from);
                                                                            if($request->to <> '')
                                                                                $query->where('created_at','<=',$request->to);
                                                                            })->orderBy('id','DESC')->get();
        $data['branch'] = Branch::all();
        $data['asset'] = Asset::all();
        $data['serviceType'] = ServiceType::all();
        $data['requests'] = $request->all();  

        return view('report',$data);
    }
    public function assetReqList($assetId){
        $auth = Auth::user();
        $data['reqStatus'] = JobRequest::with('serviceType','branch','asset','approver','requestStatusList','statusLast','payment_jobs')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branch_id',$auth->branch_id);
                                                                    })
                            ->where('asset_id',$assetId)->orderBy('id','DESC')->get();

        $allStatus = Status::all();
        $data['assetId'] = $assetId;
        $data['allStatusData'] = array();
        foreach($allStatus as $value){
            $data['allStatusData'][$value->name] = $value->id;
        }
        // dd($data);
        return view('asset.assetReqList',$data);
    }
    public function estimateAction($jobReqId){
        $auth = Auth::user();
        if($auth->branch_id == 0){
            $data['approverList'] = User::where('approverOrConsent',1)->where('id','!=',$auth->id)->get();
            $data['jobDetails'] = JobRequest::with('serviceType','branch','asset')->where('org_id',$auth->org_id)->where('id',$jobReqId)->get();
            $data['estimate'] = Estimate::with('JobRequest','service')->where('job_request_id',$jobReqId)->get();
            $data['approveList'] = EstimateApprover::with('corporateUser')->with('asset')->with('branch')->with('forwardUser')->where('req_id',$jobReqId)->get();
            $data['accessOrNot'] = EstimateApprover::where('req_id',$jobReqId)->count();
            if($data['accessOrNot']!=0){
                $approvePath = EstimateApprover::where('req_id',$jobReqId)->orderBy('id','DESC')->limit(1)->get();
                $data['approverAccessOrNot'] = EstimateApprover::where('forward_user',$auth->id)->where('id',$approvePath[0]->id)->count();
            }
            return view('estimateAction',$data);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function estimateApproved(request $request){
        $auth = Auth::user();
        
        if($auth->branch_id == 0){
            $jobReq = JobRequest::findOrFail($request->jobRequestId);
            $estimateApprover = new EstimateApprover();
            $estimateApprover->req_id = $request->jobRequestId;
            $estimateApprover->asset_id = $jobReq->assetId;
            $estimateApprover->branch_id = $jobReq->branchId;
            $estimateApprover->corporate_user_id = $auth->id;
            $estimateApprover->approver_status = $request->approves;
            if($request->forward_user != 0)
                $estimateApprover->forward_user = $request->forward_user;
            $estimateApprover->remarks = $request->remarks;
            $estimateApprover->amount = $request->amount;
            $estimateApprover->expectedDate = $request->expectedDate;
            $estimateApprover->save();

            JobRequest::where('id', $request->jobRequestId)
                  ->update(['estimateApproveOrNot' => $request->approves,'status_id'=>'16']);    

            if($request->approves==1){
                $allrequeststatuses = new AllRequestStatus();
                $allrequeststatuses->req_id = $request->jobRequestId;
                $allrequeststatuses->status_id = 15;
                $allrequeststatuses->notification = 1;
                $allrequeststatuses->corporate_notification = 1;
                $allrequeststatuses->save();
            }

            return redirect()->route('estimate',$request->jobRequestId);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function rejectEstimate(){
        $auth = Auth::user();
        $data['getData'] = JobRequest::with('serviceType','estimateApprove','branch','asset','estimate','estimateReject')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })
                            ->where('estimateApproveOrNot','=','2')->orderBy('id','DESC')->get();
        // dd($data);

        return view('estimateReject',$data);
    }

    public function tatLists(){
        $auth = Auth::user();
        $data['allRequestWithStatus'] = JobRequest::with('serviceType')->with('branch','asset','approver','allrequeststatuses')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })
                            ->orderBy('id','DESC')->get();

        $allStatus = Status::all();
        $data['organizationName'] = Organization::find(auth()->user()->org_id);
        $data['allStatusData'] = array();
        foreach($allStatus as $value){
            $data['allStatusData'][$value->name] = $value->id;
        }


        return view('tat',$data);
    }

    public function unassigned(){
        $auth = Auth::user();
        $data['recentReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        return view('unassignedList',$data);
    }
    public function waitingForEstimateApproval(){
        $auth = Auth::user();
        $data['estimateReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->with('estimate')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','=','0')->orderBy('id','DESC')->get();
        return view('waitingForEstimateApproval',$data);
    }
    public function pending(){
        $auth = Auth::user();
        $data['pending'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    $query->where('status_id',5);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })->orderBy('id','DESC')->get();
        return view('pending',$data);
    }
    public function inProcess(){
        $auth = Auth::user();
        $data['inProcess'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    $query->where('completeReq','!=',1);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })->orderBy('id','DESC')->get();

        return view('inProcess',$data);
    }
    public function waitingForEssSchedule(){
        $auth = Auth::user();
        $data['ess_schedule'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$auth->org_id);
                                                                    $query->where('status_id',0);
                                                                    if($auth->branch_id <> 0 && $auth->branch_id <> '')
                                                                        $query->where('branchId',$auth->branch_id);
                                                                    })->orderBy('id','DESC')->get();

        return view('waitingForEssSchedule',$data);
    }
}
