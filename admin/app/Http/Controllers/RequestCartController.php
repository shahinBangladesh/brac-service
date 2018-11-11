<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Branch;
use App\JobRequest;
use App\Organization;
use App\Service;
use App\ServiceType;
use App\User;
use App\JobCart;
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

class RequestCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user();
        $data['title'] = 'Cart Lists';
        $data['getData'] = JobCart::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>0)
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->get();
        return view('cart-req.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        $data['title'] = 'Job Create';
        $data['create'] = 1;
        $data['service'] = ServiceType::where('org_id',$auth->org_id)->pluck('name','id');
        $data['branch'] = Branch::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>0)
                                                                                $query->where('id',$auth->branch_id);
                                                                            })->pluck('name','id');
        /*$data['asset'] = Asset::where(function($query) use ($auth){
                                                                            $query->where('org_id',$auth->org_id);
                                                                            if($auth->branch_id <>0)
                                                                                $query->where('branch_id',$auth->branch_id);
                                                                            })->pluck('name','id');*/

        return view('cart-req.form',$data);
    }
    public function cartSubmitToRequest(Request $request){
        if(count($request->cartId)>0){
            foreach(array_filter($request->cartId) as $value){
                $jobCart = JobCart::findOrFail($value);

                $JobRequest = new JobRequest();
                $JobRequest->tokenNumber = $jobCart->tokenNumber;
                $JobRequest->service_type_id = $jobCart->service_type_id;
                $JobRequest->branch_id = $jobCart->branch_id;
                $JobRequest->asset_id = $jobCart->asset_id;
                $JobRequest->org_id = $jobCart->org_id;
                $JobRequest->status_id = 0;
                $JobRequest->phone = $request->phone;
                $JobRequest->ProblemDescription = $request->ProblemDescription;
                $JobRequest->expectedDate = $request->expectedDate;
                $JobRequest->expectedTime = $request->expectedTime;

                $JobRequest->save();


                $allrequeststatuses = new AllRequestStatus();
                $allrequeststatuses->job_request_id = $JobRequest->id;
                $allrequeststatuses->status_id = 1;
                $allrequeststatuses->save();
            }   
            $delete = JobCart::where('created_by',Auth::user()->id)->delete();
        }else{
            return redirect()->route('cart-req.index');
        }


        Session::flash('message','Successfully Created');
        return redirect()->route('req.index');
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
            'service_type_id' =>'required',
            'branch_id' =>'required',
            'asset_id' =>'required',
        ]);

        $rand1 = Str::Random(4);
        $rand2 = Str::Random(2);

        $service = ServiceType::findOrFail($request->service_type_id);
        
        foreach($request->asset_id as $value){
            $jobCart = new JobCart();
            $jobCart->service_type_id = $request->service_type_id;
            $jobCart->branch_id = $request->branch_id;
            $jobCart->asset_id = $value;
            $jobCart->org_id = Auth::user()->org_id;

            $jobCart->save();
            $jobCart->id;
            $b = JobCart::find($jobCart->id);
            $b->tokenNumber = $rand1.$jobCart->id.$rand2;
            $b->update();
        }

        Session::flash('message','Successfully Created');
        return redirect()->route('cart-req.index');
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
        //
    }
}
