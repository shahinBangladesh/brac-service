<?php

namespace App\Http\Middleware;

use Closure;
use App\AllRequestStatus;
use App\Asset;
use App\Corporate;
use Auth;

class NotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $corporate = Corporate::where('id',Auth::user()->id)->get();
        // if(auth()->check() && auth()->user()->user_Type_Id!=4){
        if(Auth::check()){
            if($request->segment(1) == 'notification'){
                $AllRequestStatus = AllRequestStatus::where(['id'=>$request->segment(4)])->first();
                if(!is_null($AllRequestStatus)){
                    if($AllRequestStatus->corporate_notification == 1){
                        AllRequestStatus::where(['id'=>$request->segment(4)])
                      ->update(['corporate_notification' => 2]);
                    }
                }
            }
            if($request->segment(1) == 'assetNotification'){
                $asset = Asset::where(['id'=>$request->segment(3)])->first();
                if($asset->notification==1){
                    Asset::where(['id'=>$request->segment(3)])
                  ->update(['notification' => 2]);
                }elseif ($asset->notification==3){
                     Asset::where(['id'=>$request->segment(3)])
                  ->update(['notification' => 4]);
                }else{

                }
            }

            $notification = AllRequestStatus::join('job_requests','job_requests.id','allrequeststatuses.req_id')
                            ->with('status')
                            ->where('allrequeststatuses.corporate_notification',1)
                            ->where(function($query) use ($corporate){
                                                                    $query->where('job_requests.org_id',$corporate[0]->org_id);
                                                                    if($corporate[0]->branch_id <>'')
                                                                        $query->where('job_requests.branchId',$corporate[0]->branch_id);
                                                                    })
                            ->select('allrequeststatuses.*')
                            ->orderBy('allrequeststatuses.id','DESC')
                            ->get();
            $oldNotification = AllRequestStatus::join('job_requests','job_requests.id','allrequeststatuses.req_id')
                                ->with('status')
                                ->where('allrequeststatuses.corporate_notification',2)
                                ->where(function($query) use ($corporate){
                                                                        $query->where('job_requests.org_id',$corporate[0]->org_id);
                                                                        if($corporate[0]->branch_id <>'')
                                                                            $query->where('job_requests.branchId',$corporate[0]->branch_id);
                                                                        })
                                ->select('allrequeststatuses.*')
                                ->orderBy('allrequeststatuses.id','DESC')
                                ->get();
            // Notification 1 for Raised Asset
            $assetNotification = Asset::
                                where('notification',1)
                                ->where(function($query) use ($corporate){
                                                                        $query->where('org_id',$corporate[0]->org_id);
                                                                        if($corporate[0]->branch_id <>'')
                                                                            $query->where('branch_id',$corporate[0]->branch_id);
                                                                        })
                                ->orderByDesc('id')
                                ->get();
            // Notification 2 for Raised Asset Seen Already
            $assetOldNotification = Asset::
                                    where('notification',2)
                                    ->where(function($query) use ($corporate){
                                                                        $query->where('org_id',$corporate[0]->org_id);
                                                                        if($corporate[0]->branch_id <>'')
                                                                            $query->where('branch_id',$corporate[0]->branch_id);
                                                                        })
                                    ->orderByDesc('id')
                                    ->get();
            // Notification 3 for Asset Approved or rejected from approver
            $assetApproveNotification = Asset::
                                        where('notification',3)
                                        ->where(function($query) use ($corporate){
                                                                        $query->where('org_id',$corporate[0]->org_id);
                                                                        if($corporate[0]->branch_id <>'')
                                                                            $query->where('branch_id',$corporate[0]->branch_id);
                                                                        })
                                        ->orderByDesc('id')
                                        ->get();
            // Notification 4 for Approved asset seen already
            $assetOldApproveNotification = Asset::
                                            where('notification',4)
                                            ->where(function($query) use ($corporate){
                                                                        $query->where('org_id',$corporate[0]->org_id);
                                                                        if($corporate[0]->branch_id <>'')
                                                                            $query->where('branch_id',$corporate[0]->branch_id);
                                                                        })
                                            ->orderByDesc('id')
                                            ->get();

            view()->composer('*', function ($view) use ($notification,$oldNotification,$assetNotification,$assetOldNotification,$assetApproveNotification,$assetOldApproveNotification) {
                $view->with(['notification'=> $notification,'oldNotification'=>$oldNotification,'assetNotification'=>$assetNotification,'assetOldNotification'=>$assetOldNotification,'assetApproveNotification'=>$assetApproveNotification,'assetOldApproveNotification'=>$assetOldApproveNotification]);
            });

            return $next($request);
        }
        return redirect()->route('login');
    }
}
