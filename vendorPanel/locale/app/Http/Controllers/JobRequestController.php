<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use App\RequestStatus;
use App\PaymentJobs;
use App\Corporate;
use App\Status;
use App\ApproverPath;
use Carbon\Carbon;
use App\Billing;
use App\Service;
use App\ServiceTypes;
use App\Brand;
use App\Branch;
use App\Asset;
use App\Payment;
use App\AllRequestStatus;
use App\Assign;
use App\JobService;
use App\AssignIntern;
use App\User;
use \App\Http\Resources\JobRequest\JobRequestResource;
use \App\Http\Resources\JobRequest\JobRequestCollection;
use App\Http\Requests\JobRequestRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Mail;

class JobRequestController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
//        $this->middleware('auth:api')->except('index','show'); to access some function
    }

    public function userAllJobRequest($ReqCreatedBy){
        $data = DB::table('job_requests')->where('job_requests.ReqCreatedBy',$ReqCreatedBy)
            ->leftJoin('assigns', 'job_requests.id', '=', 'assigns.job_request_id')
            ->leftJoin('payment_jobs', 'job_requests.id', '=', 'payment_jobs.job_request_id')
            ->leftJoin('employees', 'assigns.AssignTo', '=', 'employees.id')
            ->select('job_requests.*','employees.Name as employeesName','employees.Group','employees.Phone as employeesPhone','assigns.TechnicalInput','payment_jobs.amount as jobAmount')
            ->orderBy('job_requests.id','DESC')
            ->get();
        // dd($data);
        $dataJob = array();
        if(count($data)==0){
            // $dataJob['status'] = 'Fail';
        }else{
            // $dataJob['status'] = 'Success';
            $sl = 0;
            foreach($data as $value):
                $jobStatus = RequestStatus::with('status')->where('jobId',$value->id)->orderBy('id', 'desc')->first();
                $dataJob['data'][$sl]['id'] = $value->id;
                $dataJob['data'][$sl]['serviceId'] = $value->ServiceId;
                $dataJob['data'][$sl]['jobAmount'] = $value->jobAmount;
                if($value->ImageUrl <>'')
                    // $dataJob['data'][$sl]['ImageUrl'] = URL::to('image/jobRequest/'.$value->ImageUrl);
                    $dataJob['data'][$sl]['ImageUrl'] = $value->ImageUrl;
                else
                    $dataJob['data'][$sl]['ImageUrl'] = URL::to('image/defaultUser.png');

                $dataJob['data'][$sl]['clientName'] = $value->Name;
                $dataJob['data'][$sl]['clientPhone'] = $value->Phone;
                $dataJob['data'][$sl]['address'] = $value->Address;
                $dataJob['data'][$sl]['clientEmail'] = $value->Email;
                $dataJob['data'][$sl]['serviceItem'] = $value->ServiceItem;
                $dataJob['data'][$sl]['serviceId'] = $value->ServiceId;
                $dataJob['data'][$sl]['serviceItemId'] = $value->ServiceItemId;
                $dataJob['data'][$sl]['problemDescription'] = $value->ProblemDescription;
                $dataJob['data'][$sl]['expectedDate'] = $value->ExpectedDate;
                $dataJob['data'][$sl]['problemDescription'] = $value->ProblemDescription;
                $dataJob['data'][$sl]['employeesName'] = $value->employeesName;
                $dataJob['data'][$sl]['group'] = $value->Group;
                $dataJob['data'][$sl]['expectedTime'] = $value->ExpectedTime;
                $dataJob['data'][$sl]['employeesPhone'] = $value->employeesPhone;
                $dataJob['data'][$sl]['TechnicalInput'] = $value->TechnicalInput;

                $now = Carbon::now();
                if(!EMPTY($jobStatus)):
                    $date = Carbon::parse($jobStatus->created_at->toDateTimeString());

                    $dataJob['data'][$sl]['requestStatus'] = $jobStatus->status->name;
                    $dataJob['data'][$sl]['requestStatusDate'] = $date->format('d-m-Y H:i:s');
                else:
                    $dataJob['data'][$sl]['requestStatus'] = '';
                    $dataJob['data'][$sl]['requestStatusDate'] = '';
                endif;

                $sl++;
            endforeach;
        }
        return $dataJob;
    }
    public function jobRequestByService($ServiceId){
        $data = DB::table('job_requests')->where('job_requests.ServiceId',$ServiceId)
            ->leftJoin('assigns', 'job_requests.id', '=', 'assigns.job_request_id')
            ->leftJoin('users', 'assigns.AssignTo', '=', 'users.id')
            ->leftJoin('payment_jobs', 'payment_jobs.job_request_id', '=', 'job_requests.id')
            ->select('job_requests.*','users.name as employeesName','users.phone as employeesPhone','users.photo','assigns.TechnicalInput','payment_jobs.vat','payment_jobs.discount')
            ->get();

        $dataJob = array();
        if(count($data)==0){
            // $dataJob['status'] = 'Fail';
        }else{
            // $dataJob['status'] = 'Success';
            $billing = Billing::with('service')->where('job_request_id',$data['0']->id)->get();
            // dd($data);

            $sl = 0;
            $vat = '';
            $discount = '';
            foreach($data as $value):
                $getJobStatusLists = RequestStatus::with('status')->where('jobId',$value->id)->get();

                $dataJob['data'][$sl]['id'] = $value->ServiceId;
                $dataJob['data'][$sl]['clientName'] = $value->Name;
                $dataJob['data'][$sl]['clientPhone'] = $value->Phone;
                $dataJob['data'][$sl]['clientEmail'] = $value->Email;
                $dataJob['data'][$sl]['serviceItem'] = $value->ServiceItem;
                $dataJob['data'][$sl]['serviceId'] = $value->ServiceId;
                $dataJob['data'][$sl]['serviceItemId'] = $value->ServiceItemId;
                $dataJob['data'][$sl]['problemDescription'] = $value->ProblemDescription;
                $dataJob['data'][$sl]['expectedDate'] = $value->ExpectedDate;
                $dataJob['data'][$sl]['problemDescription'] = $value->ProblemDescription;
                $dataJob['data'][$sl]['employeesName'] = $value->employeesName;
                // $dataJob['data'][$sl]['group'] = $value->Group;
                $dataJob['data'][$sl]['group'] = '';
                if($value->photo <>'')
                    $dataJob['data'][$sl]['photo'] = url('image/userPhoto/'.$value->photo);
                else
                    $dataJob['data'][$sl]['photo'] = '';
                $dataJob['data'][$sl]['expectedTime'] = $value->ExpectedTime;
                $dataJob['data'][$sl]['employeesPhone'] = $value->employeesPhone;
                $dataJob['data'][$sl]['TechnicalInput'] = $value->TechnicalInput;

                $slReqStatus = 0;
                $now = Carbon::now();
                if(!EMPTY($getJobStatusLists)):
                    foreach($getJobStatusLists as $jobStatus):
                        $dataJob['data'][$sl]['requestStatus']['data'][$slReqStatus]['status'] = $jobStatus->status->name;
                        // $dataJob['data'][$sl]['requestStatus']['data'][$slReqStatus]['date'] = $jobStatus->created_at;
                        
                        $date = Carbon::parse($jobStatus->created_at->toDateTimeString());
                        $dataJob['data'][$sl]['requestStatus']['data'][$slReqStatus]['date'] = $date->format('d-m-Y H:i:s');
                        // $dataJob['data'][$sl]['requestStatus']['data'][$slReqStatus]['time'] = $date->format('H:i:s');

                        $slReqStatus++;
                    endforeach;
                else:
                    $dataJob['data'][$sl]['requestStatus']['data'][$slReqStatus]['status'] = '';
                    $dataJob['data'][$sl]['requestStatus']['data'][$slReqStatus]['date'] = '';
                endif;

                $sl++;

                $vat = $value->vat;
                $discount = $value->discount;
            endforeach;

            $dataJob['data']['0']['billing'] = '';
            $dataJob['data']['0']['totalAmount'] = '';
            $billingTotalAmount = 0;
            
            if(count($billing)>0){
                foreach($billing as $billingValue){
                    $dataJob['data']['0']['billing'] .= $billingValue->service->name.'    '.$billingValue->quantity.'    '.($billingValue->quantity * $billingValue->amount)."\n";
                    $billingTotalAmount += $billingValue->quantity * $billingValue->amount;

                }

                $dataJob['data']['0']['billing'] .= 'Vat '.$vat."\n";
                $dataJob['data']['0']['billing'] .= 'Discount '.$discount."\n";
                $dataJob['data']['0']['totalAmount'] = ($billingTotalAmount + (($billingTotalAmount * $vat) / 100) - $discount);
            }
        }

        return $dataJob;
    }
    public function tokenDetails($ServiceId){
        $data = DB::table('job_requests')->where('job_requests.ServiceId',$ServiceId)
            ->leftJoin('assigns', 'job_requests.id', '=', 'assigns.job_request_id')
            ->leftJoin('employees', 'assigns.AssignTo', '=', 'employees.id')
            ->select('job_requests.*','employees.Name as employeesName','employees.Group','employees.Phone as employeesPhone','assigns.TechnicalInput')
            ->get();

        // dd($data);

        $dataJob = array();
        if(count($data)==0){
            $dataJob['status'] = 'Fail';
        }else{
            foreach($data as $value):
                $getJobStatusLists = RequestStatus::with('status')->where('jobId',$value->id)->get();

                $dataJob['id'] = $value->ServiceId;
                $dataJob['clientName'] = $value->Name;
                $dataJob['clientPhone'] = $value->Phone;
                $dataJob['clientEmail'] = $value->Email;
                $dataJob['serviceItem'] = $value->ServiceItem;
                $dataJob['serviceId'] = $value->ServiceId;
                $dataJob['serviceItemId'] = $value->ServiceItemId;
                $dataJob['problemDescription'] = $value->ProblemDescription;
                $dataJob['expectedDate'] = $value->ExpectedDate;
                $dataJob['problemDescription'] = $value->ProblemDescription;
                $dataJob['employeesName'] = $value->employeesName;
                $dataJob['group'] = $value->Group;
                $dataJob['expectedTime'] = $value->ExpectedTime;
                $dataJob['employeesPhone'] = $value->employeesPhone;
                $dataJob['TechnicalInput'] = $value->TechnicalInput;

                $slReqStatus = 0;
                if(count($getJobStatusLists)>0):
                    foreach($getJobStatusLists as $jobStatus):
                        $dataJob['requestStatus'][$slReqStatus]['status'] = $jobStatus->status->name;
                        $dataJob['requestStatus'][$slReqStatus]['date'] = $jobStatus->created_at;

                        $slReqStatus++;
                    endforeach;
                else:
                    $dataJob['requestStatus'][$slReqStatus]['status'] = '';
                    $dataJob['requestStatus'][$slReqStatus]['date'] = '';
                endif;
            endforeach;
        }

        // dd($dataJob);
        $title = 'Job Details BY Token';
        return view('admin.jobRequest.tokenDetails',compact('dataJob','title'));
    }
    
    public function index()
    {
        return JobRequestCollection::collection(JobRequest::paginate(2));
    }

    public function CorporateIndex()
    {
        $data['title'] = 'Job View';
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['getData'] = JobRequest::with('serviceType')->with('branch','asset','payment_jobs')->
                            where(function($query) use ($corporate){
                                                                    $query->where('org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('branchId',$corporate[0]->branch_id);
                                                                    })->orderBy('id','DESC')->get();
        $data['status'] = Status::all();

        // dd($data);
        
        return view('corporate.jobRequest.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Job Create';
        $data['create'] = 1;
        $data['service'] = Service::all();
        $data['brand'] = Brand::all();
        $data['payments'] = Payment::all();
        return view('admin.jobRequest.form',$data);
    }
    public function corporateCreate()
    {
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['title'] = 'Job Create';
        $data['create'] = 1;
        $data['service'] = ServiceTypes::all();
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

        return view('corporate.jobRequest.form',$data);
    }
    
    
    public function myRequest($createdBy)
    {
       return JobRequestCollection::collection(JobRequest::where('ReqCreatedBy',$createdBy)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequestRequest $request)
    {
        $rand1 = Str::Random(4);
        $rand2 = Str::Random(2);
            
        $JobRequest = new JobRequest;
        $JobRequest->ServiceItem = $request->ServiceItem;
        $JobRequest->ServiceItemId = $request->ServiceItemId;
        $JobRequest->ImageUrl = $request->ImageUrl;
        $JobRequest->Name = $request->Name;
        $JobRequest->Email = $request->Email;
        $JobRequest->ProblemDescription = $request->Description;
        $JobRequest->Brand = $request->Brand;
        $JobRequest->DeviceQty = $request->DeviceQty;
        $JobRequest->Capacity = $request->Capacity;
        $JobRequest->Phone = $request->Phone;
        $JobRequest->Address = $request->Address;
        $JobRequest->ExpectedDate = $request->ExpectedDate;
        $JobRequest->ExpectedTime = $request->ExpectedTime;
        $JobRequest->PaymentMethod = $request->PaymentMethod;
        $JobRequest->ReqCreatedBy = $request->ReqCreatedBy;
        $JobRequest->save();
        $JobRequest->id;
        $b = JobRequest::find($JobRequest->id);
        $b->ServiceId=$rand1.$JobRequest->id.$rand2;
        $b->update();
        return response([
            '0'=>Response::HTTP_CREATED,
            'ServiceId'=>$b->ServiceId
        ]);
//        return response([
//            'data'=> new JobRequestResource($JobRequest),Response::HTTP_CREATED
//        ]);
    }
    public function storeWeb(Request $request)
    {
         $request->validate([
            'ServiceId' =>'required',
            'Name' =>'required|string',
            'Email' =>['nullable','unique:job_requests','email'],
            'ProblemDescription' => 'required',
            'Brand'=>'required|integer',
            'DeviceQty'=>'required|integer',
            'Phone'=> 'required'
        ]);

        $rand1 = Str::Random(4);
        $rand2 = Str::Random(2);

        $service = Service::findOrFail($request->ServiceId);
            
        $JobRequest = new JobRequest();
        $JobRequest->warranty = $request->warranty;
        $JobRequest->provider_name = $request->provider_name;
        $JobRequest->provider_ticket = $request->provider_ticket;
        $JobRequest->Name = $request->Name;
        $JobRequest->Phone = $request->Phone;
        $JobRequest->Address = $request->Address;
        $JobRequest->Email = $request->Email;
        $JobRequest->ServiceItem = $service->name;
        $JobRequest->ServiceItemId = $request->ServiceId;
        $JobRequest->serialInput = $request->serialInput;
        $JobRequest->model = $request->model;
        // $JobRequest->RequestType = $request->RequestType;
        $JobRequest->RequestType = 1;
        $JobRequest->ProblemDescription = $request->ProblemDescription;
        $JobRequest->ExpectedDate = $request->ExpectedDate;
        $JobRequest->ExpectedTime = $request->ExpectedTime;
        $JobRequest->Brand = $request->Brand;
        $JobRequest->DeviceQty = $request->DeviceQty;
        $JobRequest->Capacity = $request->Capacity;
        $JobRequest->ProbableCompletionDate = $request->ProbableCompletionDate;
        $JobRequest->PaymentMethod = $request->PaymentMethod;
        $JobRequest->ReqCreatedBy = Auth::id();
        $JobRequest->RequestNote = $request->RequestNote;
        $JobRequest->location = $request->location;
        $JobRequest->purchase = $request->purchase;
        $JobRequest->reference = $request->reference;
        $JobRequest->referrenceShowRoom = $request->referrenceShowRoom;
        $JobRequest->serialNumber = $request->serialNumber;
        $JobRequest->actualFault1 = $request->actualFault1;
        $JobRequest->actualFault2 = $request->actualFault2;
        $JobRequest->actualFault3 = $request->actualFault3;

        $JobRequest->diagonosis = $request->diagonosis;
        $JobRequest->rootCause = $request->rootCause;
        $JobRequest->corrective_action = $request->corrective_action;
        $JobRequest->prevention = $request->prevention;

        if ($request->hasFile('ImageUrl')) {
            $file = $request->file('ImageUrl');
            $destinationPath = 'image/jobRequest';
            $JobRequest->ImageUrl = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->ImageUrl);
        }

        if ($request->hasFile('diagonosisPhoto')) {
            $file = $request->file('diagonosisPhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->diagonosisPhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->diagonosisPhoto);
        }
        if ($request->hasFile('rootCausePhoto')) {
            $file = $request->file('rootCausePhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->rootCausePhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->rootCausePhoto);
        }
        if ($request->hasFile('corrective_actionPhoto')) {
            $file = $request->file('corrective_actionPhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->corrective_actionPhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->corrective_actionPhoto);
        }
        if ($request->hasFile('preventionPhoto')) {
            $file = $request->file('preventionPhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->preventionPhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->preventionPhoto);
        }
        // dd($JobRequest);
        $JobRequest->save();
        $JobRequest->id;
        $b = JobRequest::find($JobRequest->id);
        $b->ServiceId=$rand1.$JobRequest->id.$rand2;
        $b->update();
        
        Session::flash('message','Successfully Created');
        return redirect()->route('allJobRequest.list');
    }
    public function CorporateStore(Request $request)
    {
        $request->validate([
            'ServiceId' =>'required',
            'branchId' =>'required',
            'assetId' =>'required',
        ]);

        $rand1 = Str::Random(4);
        $rand2 = Str::Random(2);

        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->first();

        $service = ServiceTypes::findOrFail($request->ServiceId);
        
        $JobRequest = new JobRequest();
        // $JobRequest->grade = $request->grade;
        $JobRequest->ServiceItem = $service->name;
        $JobRequest->serviceTypeId = $request->ServiceId;
        $JobRequest->branchId = $request->branchId;
        $JobRequest->org_id = $corporate->org_id;
        $JobRequest->Phone = $request->Phone;
        $JobRequest->assetId = $request->assetId;
        $JobRequest->ProblemDescription = $request->ProblemDescription;
        $JobRequest->ExpectedDate = $request->ExpectedDate;
        $JobRequest->ExpectedTime = $request->ExpectedTime;
        $JobRequest->DeviceQty = 1;
        // dd($JobRequest);
        $JobRequest->save();
        $JobRequest->id;
        $b = JobRequest::find($JobRequest->id);
        $b->ServiceId=$rand1.$JobRequest->id.$rand2;
        $b->update();


        $allrequeststatuses = new AllRequestStatus();
        $allrequeststatuses->req_id = $JobRequest->id;
        $allrequeststatuses->status_id = 11;
        $allrequeststatuses->notification = 1;
        $allrequeststatuses->corporate_notification = 1;
        $allrequeststatuses->save();
        
        
        /*Mail::send(['text'=>'mail'], $corporate, function($message) {
         $message->to($corporate->email, 'ESS')->subject
            ('A New Request Generate');
         $message->from('unifoxdigital.mizan@gmail.com','Corporate New Job Request');
        });*/
        /*$data = array('email'=>$corporate->email);
        Mail::send('mail', $data, function($message) use ($corporate) {
         $message->to($corporate->email, $corporate->name)->subject
            ('A New Request Generate');
         $message->from('unifoxdigital.mizan@gmail.com','Corporate new Job Request');
        });*/
   
        
        
        Session::flash('message','Successfully Created');
        return redirect()->route('corporate.req.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return \App\JobRequest:: where('id',$id)->first();
        // return ProductResource::collection(Product::all());﻿
        return new JobRequestResource(JobRequest::where('ServiceId',$id)->first());
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['job'] = JobRequest::findOrFail($id);
        $data['title'] = 'Job Edit';
        $data['create'] = 0;
        $data['service'] = Service::all();
        $data['brand'] = Brand::all();
        $data['payments'] = Payment::all();
        return view('admin.jobRequest.form',$data);
    }
    public function CorporateEdit($id)
    {
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['jobRequest'] = JobRequest::findOrFail($id);
        $data['title'] = 'Job Edit';
        $data['create'] = 0;
        $data['service'] = Service::all();
        $data['branch'] = Branch::where('org_id',$corporate[0]->org_id)->get();
        $data['asset'] = Asset::where('org_id',$corporate[0]->org_id)->get();
        return view('corporate.jobRequest.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviceid)
    {
        $request['ProblemDescription'] = $request->Description;
        unset($request['Description']);
        $JobRequest = JobRequest::where('ServiceId',$serviceid)->first();
        $JobRequest->update($request->all());
       return response([
            'data'=> new JobRequestResource($JobRequest),Response::HTTP_OK
        ]);
    }
    public function updateWeb(Request $request, $id)
    {
        $request->validate([
            'Email' =>['nullable','email'],
            'DeviceQty'=>'required|integer'
        ]);

        $rand1 = Str::Random(4);
        $rand2 = Str::Random(2);

        $service = Service::find($request->ServiceId);
            
        $JobRequest = jobRequest::findOrFail($id);
        $JobRequest->warranty = $request->warranty;
        $JobRequest->provider_name = $request->provider_name;
        $JobRequest->provider_ticket = $request->provider_ticket;
        $JobRequest->Name = $request->Name;
        $JobRequest->Phone = $request->Phone;
        $JobRequest->Address = $request->Address;
        $JobRequest->Email = $request->Email;
        if($request->ServiceId<>'' && count($service)>0){
            $JobRequest->ServiceItem = $service->name;
            $JobRequest->ServiceItemId = $request->ServiceId;
        }
        $JobRequest->RequestType = 1;
        $JobRequest->ProblemDescription = $request->ProblemDescription;
        $JobRequest->serialInput = $request->serialInput;
        $JobRequest->model = $request->model;
        $JobRequest->ExpectedDate = $request->ExpectedDate;
        $JobRequest->ExpectedTime = $request->ExpectedTime;
        $JobRequest->Brand = $request->Brand;
        $JobRequest->DeviceQty = $request->DeviceQty;
        $JobRequest->Capacity = $request->Capacity;
        $JobRequest->ProbableCompletionDate = $request->ProbableCompletionDate;
        $JobRequest->PaymentMethod = $request->PaymentMethod;
        $JobRequest->ReqCreatedBy = Auth::id();
        $JobRequest->RequestNote = $request->RequestNote;
        $JobRequest->location = $request->location;
        $JobRequest->purchase = $request->purchase;
        $JobRequest->reference = $request->reference;
        $JobRequest->referrenceShowRoom = $request->referrenceShowRoom;
        $JobRequest->serialNumber = $request->serialNumber;
        $JobRequest->actualFault1 = $request->actualFault1;
        $JobRequest->actualFault2 = $request->actualFault2;
        $JobRequest->actualFault3 = $request->actualFault3;

        if ($request->hasFile('ImageUrl')) {
            $file = $request->file('ImageUrl');
            $destinationPath = 'image/jobRequest';
            $JobRequest->ImageUrl = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->ImageUrl);
        }

        $JobRequest->diagonosis = $request->diagonosis;
        $JobRequest->rootCause = $request->rootCause;
        $JobRequest->corrective_action = $request->corrective_action;
        $JobRequest->prevention = $request->prevention;

        if ($request->hasFile('diagonosisPhoto')) {
            $file = $request->file('diagonosisPhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->diagonosisPhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->diagonosisPhoto);
        }
        if ($request->hasFile('rootCausePhoto')) {
            $file = $request->file('rootCausePhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->rootCausePhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->rootCausePhoto);
        }
        if ($request->hasFile('corrective_actionPhoto')) {
            $file = $request->file('corrective_actionPhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->corrective_actionPhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->corrective_actionPhoto);
        }
        if ($request->hasFile('preventionPhoto')) {
            $file = $request->file('preventionPhoto');
            $destinationPath = 'image/jobRequest';
            $JobRequest->preventionPhoto = $file->getClientOriginalName();
            $file->move($destinationPath,$JobRequest->preventionPhoto);
        }
        // dd($JobRequest);
        $JobRequest->save();
        $JobRequest->id;
        $b = JobRequest::find($JobRequest->id);
        $b->ServiceId=$rand1.$JobRequest->id.$rand2;
        $b->update();
        
        Session::flash('message','Successfully Updated');
        return redirect()->route('allJobRequest.list');
        }
    public function CorporateUpdate(Request $request, $id)
    {
        $request->validate([
            'ServiceId' =>'required',
            'branchId' =>'required',
            'assetId' =>'required',
        ]);

        $rand1 = Str::Random(4);
        $rand2 = Str::Random(2);

        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();

        $service = Service::findOrFail($request->ServiceId);
            
        $JobRequest = jobRequest::findOrFail($id);
        // $JobRequest->grade = $request->grade;
        $JobRequest->ServiceItem = $service->name;
        $JobRequest->ServiceItemId = $request->ServiceId;
        $JobRequest->branchId = $request->branchId;
        $JobRequest->org_id = $corporate[0]->org_id;
        $JobRequest->assetId = $request->assetId;
        $JobRequest->ProblemDescription = $request->ProblemDescription;
        $JobRequest->ExpectedDate = $request->ExpectedDate;
        $JobRequest->ExpectedTime = $request->ExpectedTime;
        $JobRequest->save();
        $JobRequest->id;
        $b = JobRequest::find($JobRequest->id);
        $b->ServiceId=$rand1.$JobRequest->id.$rand2;
        $b->update();
        
        Session::flash('message','Successfully Created');
        return redirect()->route('corporate.req.index');
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reqStatus = RequestStatus::where('jobId',$id)->delete();
        $payment_jobs = PaymentJobs::where('job_request_id',$id)->delete();
        $billing = Billing::where('job_request_id',$id)->delete();
        $job_requests = JobRequest::findOrFail($id)->delete();
        
        Session::flash('message','Successfully Deleted');
        return redirect()->route('allJobRequest.list');
    }
    /*public function CorporateDestroy($id)
    {
        $reqStatus = RequestStatus::where('jobId',$id)->delete();
        $payment_jobs = PaymentJobs::where('job_request_id',$id)->delete();
        $billing = Billing::where('job_request_id',$id)->delete();
        $job_requests = JobRequest::findOrFail($id)->delete();
        
        Session::flash('message','Successfully Deleted');
        return redirect()->route('allJobRequest.list');
    }*/
    public function list(){
        $dataJob['getData'] = JobRequest::where('org_id','!=',0)->with('statusLast','assign','payment_jobs','jobServiceToServiceName')->orderBy('id','DESC')->get();
        $dataJob['title'] = 'Job Request View';
        $dataJob['employees'] = User::where('user_Type_Id','!=',1)->get();
        $dataJob['service'] = Service::all();
        $dataJob['status'] = Status::all();
        // dd($dataJob);
        return view('admin.jobRequest.index',$dataJob);
    }
    public function assignJob(Request $request){
        $assign = new Assign();
        $assign->job_request_id = $request->jobId;
        $assign->service_id = $request->serviceId;
        $assign->AssignTo = $request->assignId;
        $assign->TechnicalInput = $request->TechnicalInput;
        $assign->leave_time = $request->leave_time;
        $assign->AssignedBy = Auth::id();
        $assign->save();

        if(count(array_filter($request->assignIntern))>0){
            AssignIntern::where('jobId',$request->jobId)->delete();
            foreach(array_filter($request->assignIntern) as $value){
                $assignIntern = new AssignIntern();
                $assignIntern->jobId = $request->jobId;
                $assignIntern->userId = $value;
                $assignIntern->assignBy = Auth::id();
                $assignIntern->save();
            }
        }

        Session::flash('message','Successfully Assigned');
        return redirect()->route('allJobRequest.list');
    }
    public function assignService(Request $request){
        $reqStatus = JobService::where('job_request_id',$request->jobId)->delete();

        foreach($request->serviceId as $value):
            if($value != ''):
                $JobService = new JobService();
                $JobService->job_request_id = $request->jobId;
                $JobService->service_id = $value;
                $JobService->assignedBy = Auth::id();
                $JobService->save();
            endif;
        endforeach;
        Session::flash('message','Successfully Service Assigned');
        return redirect()->route('allJobRequest.list');
    }
    public function servicePayment(Request $request){
        $JobService = JobService::with('service')->with('job')->where('job_request_id',$request->jobId)->get();

        $amount = 0;
        foreach($JobService as $value){
            $billings = new Billing();
            $billings->job_request_id = $value->job_request_id;
            $billings->service_id = $value->service_id;
            $billings->quantity = $value->job->DeviceQty;
            $billings->amount = $value->service->base_price;
            $billings->remarks = $request->remarks;

            $amount += $billings->amount;

            $billings->save();
        }

        $PaymentJobs = new PaymentJobs();
        $PaymentJobs->job_request_id = $request->jobId;
        $PaymentJobs->discount = $request->discount;
        $PaymentJobs->remarks = $request->remarks;
        $PaymentJobs->vat = $request->vat;

        if($PaymentJobs->vat != 0)
            $vat = (($amount-$PaymentJobs->discount) * $PaymentJobs->vat)/100;
        else
            $vat = 0;

        $PaymentJobs->totalAmount = ($amount-$PaymentJobs->discount) + $vat;

        $PaymentJobs->amount = $amount;

        $PaymentJobs->save();


        $jobRequest = JobRequest::findOrFail($request->jobId);
        $jobRequest->gotPayment = 1;
        $jobRequest->save();

        Session::flash('message','Successfully Service Assigned');
        return redirect()->route('job.invoice',$request->jobId);
    }
    public function jobInvoice($jobId){
        $dataJob['title'] = 'Payment Invoice View';
        $dataJob['jobDetails'] = JobRequest::with('brand')->with('paymentMethod')->with('payment_jobs')->where('id',$jobId)->get();
        $dataJob['billing'] = Billing::with('service')->where('job_request_id',$jobId)->get();    
        return view('admin.jobRequest.invoice',$dataJob);
    }
    public function jobDetails($jobId){
        $data['title'] = 'Job Details';
        $data['jobDetails'] = JobRequest::with('brand')->with('paymentMethod')->with('payment_jobs')->with('service')->where('id',$jobId)->get();
        $data['billing'] = Billing::with('service')->where('job_request_id',$jobId)->get();
        $data['assigns'] = Assign::with('assignto')->where('job_request_id',$jobId)->get();
        $data['AssignIntern'] = AssignIntern::with('assignto')->where('jobId',$jobId)->get();
        // dd($data);
        return view('admin.jobRequest.details',$data);
    }
    public function CorporateDetails($jobId){
        $dataJob['title'] = 'Job Details';
        $dataJob['jobDetails'] = JobRequest::with('brand')->with('paymentMethod')->with('payment_jobs')->with('service')->with('branch')->with('asset')->where('id',$jobId)->get();
        $dataJob['billing'] = Billing::with('service')->where('job_request_id',$jobId)->get();


        /*Request Status */
        $data = DB::table('job_requests')
            ->join('assigns', 'job_requests.id', '=', 'assigns.job_request_id')
            ->join('users', 'assigns.AssignTo', '=', 'users.id')
            ->select('job_requests.*','users.name as employeesName','users.position','users.phone as employeesPhone','assigns.TechnicalInput','assigns.AssignTo','assigns.id as assignId')
            ->where('job_requests.id',$jobId)
            ->get();

        $sl = 0;

        $dataJob['getData'] = array();
        foreach($data as $value):
            $getJobStatusLists = RequestStatus::with('status')->join('assigns','request_statuses.AssignID','=','assigns.id')->join('users','assigns.AssignTo','=','users.id')->select('request_statuses.*','users.name','users.phone','users.photo','users.position')->where('jobId',$value->id)->get();

            $dataJob['getData']['id'] = $value->id;
            $dataJob['getData']['assignId'] = $value->assignId;
            $dataJob['getData']['serviceId'] = $value->ServiceId;
            $dataJob['getData']['AssignTo'] = $value->AssignTo;
            $dataJob['getData']['clientName'] = $value->Name;
            $dataJob['getData']['clientPhone'] = $value->Phone;
            $dataJob['getData']['clientEmail'] = $value->Email;
            $dataJob['getData']['serviceItem'] = $value->ServiceItem;
            $dataJob['getData']['serviceId'] = $value->ServiceId;
            $dataJob['getData']['serviceItemId'] = $value->ServiceItemId;
            $dataJob['getData']['problemDescription'] = $value->ProblemDescription;
            $dataJob['getData']['expectedDate'] = $value->ExpectedDate;
            $dataJob['getData']['problemDescription'] = $value->ProblemDescription;
            $dataJob['getData']['employeesName'] = $value->employeesName;
            $dataJob['getData']['position'] = $value->position;
            $dataJob['getData']['expectedTime'] = $value->ExpectedTime;
            $dataJob['getData']['employeesPhone'] = $value->employeesPhone;
            $dataJob['getData']['TechnicalInput'] = $value->TechnicalInput;

            $slReqStatus = 0;
            // $dataJob['getData']['requestStatus'] = '';
            $now = Carbon::now();
            if(count($getJobStatusLists)>0){
                foreach($getJobStatusLists as $jobStatus):
                    //$date = Carbon::parse($jobStatus->created_at->toDateString());

                    $dataJob['getData']['requestStatus'][$slReqStatus]['id'] = $jobStatus->ID;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['AssignID'] = $jobStatus->AssignID;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['jobId'] = $jobStatus->jobId;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['status'] = $jobStatus->status->name;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['reschedule_date'] = $jobStatus->reschedule_date;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['completion_time'] = $jobStatus->completion_time;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['expected_date'] = $jobStatus->expected_date;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['Remarks'] = $jobStatus->Remarks;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['name'] = $jobStatus->name;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['phone'] = $jobStatus->phone;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['photo'] = $jobStatus->photo;
                    $dataJob['getData']['requestStatus'][$slReqStatus]['position'] = $jobStatus->position;
                    //$dataJob['getData']['requestStatus'][$slReqStatus]['created_at'] = $date->diffInDays($now);
                    $dataJob['getData']['requestStatus'][$slReqStatus]['created_at'] = $jobStatus->created_at;

                    $slReqStatus++;
                endforeach;
            }

            $sl++;
        endforeach;
        $dataJob['approveList'] = ApproverPath::with('corporateUser')->with('asset')->with('branch')->with('corporateForwardUser')->where('req_id',$jobId)->get();
        // dd($dataJob);
        return view('corporate.jobRequest.details',$dataJob);
    }
    public function jobDetailsPrint($jobId){
        $data['title'] = 'Job Details';
        $data['jobDetails'] = JobRequest::with('brand')->with('paymentMethod')->with('payment_jobs')->with('service')->where('id',$jobId)->get();
        // dd($data);
        $data['billing'] = Billing::with('service')->where('job_request_id',$jobId)->get();
        // dd($data);
        return view('admin.jobRequest.detailsPrint',$data);
    }
}
