<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Corporate;
use App\Branch;
use App\ServiceTypes;
use App\RequestStatus;
use App\Status;
use App\Organization;
use App\Billing;
use App\Estimate;
use App\AllRequestStatus;
use App\ApproverPath;
use App\EstimateApprover;
use App\JobRequest;
use App\Asset;
use Illuminate\Support\Facades\DB;

class CorporateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:corporate');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['title'] = 'Dashboard';
        //Dashboard All Count
        $data['ess_schedule'] = JobRequest::where(function($query) use ($corporate){
                                                                            $query->where('org_id',$corporate[0]->org_id);
                                                                            $query->where('status_id',0);
                                                                            if($corporate[0]->branch_id <>'')
                                                                                $query->where('branchId',$corporate[0]->branch_id);
                                                                            })->count();
        $data['pending'] = JobRequest::where(function($query) use ($corporate){
                                                                            $query->where('org_id',$corporate[0]->org_id);
                                                                            $query->where('status_id',5);
                                                                            if($corporate[0]->branch_id <>'')
                                                                                $query->where('id',$corporate[0]->branch_id);
                                                                            })->count();
        $data['asset'] = Asset::where(function($query) use ($corporate){
                                                                            $query->where('org_id',$corporate[0]->org_id);
                                                                            if($corporate[0]->branch_id <>'')
                                                                                $query->where('branch_id',$corporate[0]->branch_id);
                                                                            })->count();
        $data['jobRequest'] = JobRequest::where(function($query) use ($corporate){
                                                                            $query->where('org_id',$corporate[0]->org_id);
                                                                            if($corporate[0]->branch_id <>'')
                                                                                $query->where('branchId',$corporate[0]->branch_id);
                                                                            })->count();
        // Recent Request List
        $data['recentReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->where('status_id',0)->orderBy('id','DESC')->get();


        // Recent Request List
        $data['allRequestWithStatus'] = JobRequest::with('serviceType')->with('branch','asset','approver','allrequeststatuses')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->orderBy('id','DESC')->take(10)->get();
        // dd($data);
        $data['recentApproverReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->with('approver')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('approveOrNot','!=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        // Recent Request List
        $data['estimateReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->with('estimate')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','=','0')->orderBy('id','DESC')->get();
        $data['estimateApproveReq'] = JobRequest::with('serviceType','branch','asset','estimateApprove')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','!=','0')->orderBy('id','DESC')->get();

        // Recent Asset List
        $data['assetReq'] = Asset::with('type','branch')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branch_id',$corporate[0]->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->orderBy('id','DESC')->get();

        $data['assetApproverReq'] = Asset::with('type','branch','lastApprove')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branch_id',$corporate[0]->branch_id);
                                                                    })
                            ->where('approveOrNot','!=','0')->orderBy('id','DESC')->get();
                                   
         // Request with Status List
        $data['reqStatus'] = JobRequest::with('serviceType')->with('branch','asset','approver','requestStatusList','statusLast','lastStatusFromAllRequestStaus')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('status_id','!=',0)->where('completeReq','!=',1)->orderBy('id','DESC')->get();

        $data['inProcess'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    $query->where('completeReq','!=',1);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })->count();

        // Complete Request
        $data['completeStatus'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('completeReq',1)->orderBy('id','DESC')->get();
        $allStatus = Status::all();
        $data['organizationName'] = Organization::find(auth()->user()->org_id);
        $data['allStatusData'] = array();
        foreach($allStatus as $value){
            $data['allStatusData'][$value->name] = $value->id;
        }
        // dd($data['reqStatus']);
        return view('corporate.dashboard',$data);
    }
    public function approveAction($jobReqId){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        if($corporate[0]->branch_id == null){
            $data['approverList'] = Corporate::where('approverOrConsent',1)->where('id','!=',Auth::guard('corporate')->user()->id)->get();
            $data['jobDetails'] = JobRequest::with('serviceType')->with('branch')->with('asset')->where('org_id',$corporate[0]->org_id)->where('id',$jobReqId)->get();
            $data['approveList'] = ApproverPath::with('corporateUser')->with('asset')->with('branch')->with('corporateForwardUser')->where('req_id',$jobReqId)->get();
            $data['accessOrNot'] = ApproverPath::where('req_id',$jobReqId)->count();
            $data['reqStatus'] = RequestStatus::where('jobId',$jobReqId)->count();
            if($data['accessOrNot']!=0){
                $approvePath = ApproverPath::where('req_id',$jobReqId)->orderBy('id','DESC')->limit(1)->get();
                $data['approverAccessOrNot'] = ApproverPath::where('forward_user',Auth::guard('corporate')->user()->id)->where('id',$approvePath[0]->id)->count();
            }
            // dd($data);
            return view('corporate.approveAction',$data);
        }else{
            return redirect()->route('corporate.dashboard');
        }
    }
    public function reqApproved(request $request){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();

        if($request->approves==2){
            $this->validate($request, [
                'captcha' => 'required|captcha',
                'remarks' => 'required'
            ]);
        }
        
        if($corporate[0]->branch_id == null){
            $jobReq = JobRequest::findOrFail($request->jobRequestId);
            $approverpaths = new ApproverPath();
            $approverpaths->req_id = $request->jobRequestId;
            $approverpaths->asset_id = $jobReq->assetId;
            $approverpaths->branch_id = $jobReq->branchId;
            $approverpaths->corporate_user_id = Auth::guard('corporate')->id();
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

            return redirect()->route('corporate.approved',$request->jobRequestId);
        }else{
            return redirect()->route('corporate.dashboard');
        }
    }
    public function report(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        // if($corporate[0]->branch_id == null){
            $data['branch'] = Branch::where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('id',$corporate[0]->branch_id);
                                                                    })->get();
            $data['asset'] = Asset::where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branch_id',$corporate[0]->branch_id);
                                                                    })->get();
            $data['serviceType'] = ServiceTypes::all();
            $data['requests'] = '';
            $data['jobRequest'] = '';
            return view('corporate.report',$data);
        /*}else{
            return redirect()->route('corporate.dashboard');
        }*/
    }
    public function getReport(request $request){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['jobRequest'] = JobRequest::with('serviceType','branch','asset','status','statusLast')->where(function($query) use ($corporate,$request){
                                                                            $query->where('org_id',$corporate[0]->org_id);
                                                                            if($request->branch != 0)
                                                                                $query->where('branchId',$request->branch);
                                                                            if($request->asset != 0)
                                                                                $query->where('assetId',$request->asset);
                                                                            if($request->serviceType != 0)
                                                                                $query->where('serviceTypeId',$request->serviceType);
                                                                            if($request->from <> '')
                                                                                $query->where('created_at','>=',$request->from);
                                                                            if($request->to <> '')
                                                                                $query->where('created_at','<=',$request->to);
                                                                            })->orderBy('id','DESC')->get();
        $data['branch'] = Branch::all();
        $data['asset'] = Asset::all();
        $data['serviceType'] = ServiceTypes::all();
        $data['requests'] = $request->all();  

        return view('corporate.report',$data);
    }
    public function assetReqList($assetId){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['reqStatus'] = JobRequest::with('serviceType')->with('branch')->with('asset')->with('approver')->with('requestStatusList')->with('statusLast')->with('payment_jobs')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('assetId',$assetId)->orderBy('id','DESC')->get();

        $allStatus = Status::all();
        $data['assetId'] = $assetId;
        $data['allStatusData'] = array();
        foreach($allStatus as $value){
            $data['allStatusData'][$value->name] = $value->id;
        }
        // dd($data);
        return view('corporate.asset.assetReqList',$data);
    }
    public function estimateAction($jobReqId){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        if($corporate[0]->branch_id == null){
            $data['approverList'] = Corporate::where('approverOrConsent',1)->where('id','!=',Auth::guard('corporate')->user()->id)->get();
            $data['jobDetails'] = JobRequest::with('serviceType')->with('branch')->with('asset')->where('org_id',$corporate[0]->org_id)->where('id',$jobReqId)->get();
            $data['estimate'] = Estimate::with('JobRequest','service')->where('job_request_id',$jobReqId)->get();
            $data['approveList'] = EstimateApprover::with('corporateUser')->with('asset')->with('branch')->with('corporateForwardUser')->where('req_id',$jobReqId)->get();
            $data['accessOrNot'] = EstimateApprover::where('req_id',$jobReqId)->count();
            if($data['accessOrNot']!=0){
                $approvePath = EstimateApprover::where('req_id',$jobReqId)->orderBy('id','DESC')->limit(1)->get();
                $data['approverAccessOrNot'] = EstimateApprover::where('forward_user',Auth::guard('corporate')->user()->id)->where('id',$approvePath[0]->id)->count();
            }
            return view('corporate.estimateAction',$data);
        }else{
            return redirect()->route('corporate.dashboard');
        }
    }

    public function estimateApproved(request $request){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        
        if($corporate[0]->branch_id == null){
            $jobReq = JobRequest::findOrFail($request->jobRequestId);
            $estimateApprover = new EstimateApprover();
            $estimateApprover->req_id = $request->jobRequestId;
            $estimateApprover->asset_id = $jobReq->assetId;
            $estimateApprover->branch_id = $jobReq->branchId;
            $estimateApprover->corporate_user_id = Auth::guard('corporate')->id();
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

            return redirect()->route('corporate.estimate',$request->jobRequestId);
        }else{
            return redirect()->route('corporate.dashboard');
        }
    }
    public function rejectEstimate(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['getData'] = JobRequest::with('serviceType','estimateApprove','branch','asset','estimate','estimateReject')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('estimateApproveOrNot','=','2')->orderBy('id','DESC')->get();
        // dd($data);

        return view('corporate.estimateReject',$data);
    }

    public function tatLists(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['allRequestWithStatus'] = JobRequest::with('serviceType')->with('branch','asset','approver','allrequeststatuses')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->orderBy('id','DESC')->get();

        $allStatus = Status::all();
        $data['organizationName'] = Organization::find(auth()->user()->org_id);
        $data['allStatusData'] = array();
        foreach($allStatus as $value){
            $data['allStatusData'][$value->name] = $value->id;
        }


        return view('corporate.tat',$data);
    }

    public function unassigned(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['recentReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('approveOrNot','=','0')->where('status_id',0)->orderBy('id','DESC')->get();

        return view('corporate.unassignedList',$data);
    }
    public function waitingForEstimateApproval(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['estimateReq'] = JobRequest::with('serviceType')->with('branch')->with('asset')->with('estimate')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })
                            ->where('estimateReq','=','1')->where('estimateApproveOrNot','=','0')->orderBy('id','DESC')->get();
        return view('corporate.waitingForEstimateApproval',$data);
    }
    public function pending(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['pending'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    $query->where('status_id',5);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })->orderBy('id','DESC')->get();
        return view('corporate.pending',$data);
    }
    public function inProcess(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['inProcess'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    $query->where('completeReq','!=',1);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })->orderBy('id','DESC')->get();

        return view('corporate.inProcess',$data);
    }
    public function waitingForEssSchedule(){
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['ess_schedule'] = JobRequest::with('serviceType')->with('branch')->with('asset')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    $query->where('status_id',0);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })->orderBy('id','DESC')->get();

        return view('corporate.waitingForEssSchedule',$data);
    }
}
