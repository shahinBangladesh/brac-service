<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobRequest;
use App\RequestStatus;
use Carbon\Carbon;
use App\Status;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class RequestStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('job_requests')
            ->join('assigns', 'job_requests.id', '=', 'assigns.job_request_id')
            ->join('users', 'assigns.AssignTo', '=', 'users.id')
            ->select('job_requests.*','users.name as employeesName','users.position','users.phone as employeesPhone','assigns.TechnicalInput','assigns.AssignTo','assigns.id as assignId')
            ->get();

        $sl = 0;

        $dataJob['getData'] = array();
        foreach($data as $value):
            $getJobStatusLists = RequestStatus::with('status')->join('assigns','request_statuses.AssignID','=','assigns.id')->join('users','assigns.AssignTo','=','users.id')->select('request_statuses.*','users.name','users.phone','users.photo','users.position')->where('jobId',$value->id)->get();

            $dataJob['getData'][$sl]['id'] = $value->id;
            $dataJob['getData'][$sl]['assignId'] = $value->assignId;
            $dataJob['getData'][$sl]['serviceId'] = $value->ServiceId;
            $dataJob['getData'][$sl]['AssignTo'] = $value->AssignTo;
            $dataJob['getData'][$sl]['clientName'] = $value->Name;
            $dataJob['getData'][$sl]['clientPhone'] = $value->Phone;
            $dataJob['getData'][$sl]['clientEmail'] = $value->Email;
            $dataJob['getData'][$sl]['serviceItem'] = $value->ServiceItem;
            $dataJob['getData'][$sl]['serviceId'] = $value->ServiceId;
            $dataJob['getData'][$sl]['serviceItemId'] = $value->ServiceItemId;
            $dataJob['getData'][$sl]['problemDescription'] = $value->ProblemDescription;
            $dataJob['getData'][$sl]['expectedDate'] = $value->ExpectedDate;
            $dataJob['getData'][$sl]['problemDescription'] = $value->ProblemDescription;
            $dataJob['getData'][$sl]['employeesName'] = $value->employeesName;
            $dataJob['getData'][$sl]['position'] = $value->position;
            $dataJob['getData'][$sl]['expectedTime'] = $value->ExpectedTime;
            $dataJob['getData'][$sl]['employeesPhone'] = $value->employeesPhone;
            $dataJob['getData'][$sl]['TechnicalInput'] = $value->TechnicalInput;

            $slReqStatus = 0;
            $now = Carbon::now();
            if(count($getJobStatusLists)>0){
                foreach($getJobStatusLists as $jobStatus):
                    //$date = Carbon::parse($jobStatus->created_at->toDateString());

                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['id'] = $jobStatus->ID;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['AssignID'] = $jobStatus->AssignID;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['jobId'] = $jobStatus->jobId;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['status'] = $jobStatus->status->name;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['reschedule_date'] = $jobStatus->reschedule_date;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['completion_time'] = $jobStatus->completion_time;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['expected_date'] = $jobStatus->expected_date;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['Remarks'] = $jobStatus->Remarks;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['name'] = $jobStatus->name;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['phone'] = $jobStatus->phone;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['photo'] = $jobStatus->photo;
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['position'] = $jobStatus->position;
                    //$dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['created_at'] = $date->diffInDays($now);
                    $dataJob['getData'][$sl]['requestStatus'][$slReqStatus]['created_at'] = $jobStatus->created_at;

                    $slReqStatus++;
                endforeach;
            }

            $sl++;
        endforeach;

        $dataJob['title'] = 'Request Status View';
        $dataJob['status'] = Status::all();
        //dd($dataJob);
        return view('admin.reqStatus.index',$dataJob);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Request Status Create';
        $data['create'] = 1;
        return view('admin.reqStatus.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = JobRequest::findOrFail($request->jobId);

        $requestStatus = new RequestStatus();
        $requestStatus->AssignID = $request->assignId;
        $requestStatus->jobId = $request->jobId;
        $requestStatus->Status = $request->Status;
        $requestStatus->reschedule_date = $request->reschedule_date;
        $requestStatus->completion_time = $request->completion_time;
        $requestStatus->expected_date = $request->expected_date;
        $requestStatus->Remarks = $request->Remarks;
        if($request->has('completeReq'))
            $requestStatus->completeReq = $request->completeReq;

        $requestStatus->save();

        $req->status_id = $request->Status;
        if($request->has('completeReq'))
            $req->completeReq = 1;
        $req->save();

        Session::flash('message','Successfully Status Changed');
        // return redirect()->route('requestStatus.index');
        return back();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestStatus::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('requestStatus.index');
    }
}
