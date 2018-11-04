<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\CorporateUser;
use App\Corporate;
use App\CorporateUserType;
use App\Organization;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CorporateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Users View';
        $getData = CorporateUser::with('userType')->with('organization')->orderby('id','DESC')->get();
        return view('admin.corporateuser.index',compact('title','getData'));
    }
    public function corporateIndex()
    {
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        if($corporate[0]->branch_id == null){
            $title = 'Users View';
            $getData = CorporateUser::with('userType')->with('organization')->where('org_id',$corporate[0]->org_id)->orderby('id','DESC')->get();
            return view('corporate.user.index',compact('title','getData'));
        }else{
            return redirect()->route('corporate.dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Users Create';
        $data['create'] = 1;
        $data['userType'] = CorporateUserType::all();
        $data['organization'] = Organization::where('status',1)->get();
        $data['branch'] = Branch::all();
        
        return view('admin.corporateuser.form',$data);
    }
    public function corporateCreate()
    {
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        if($corporate[0]->branch_id == null){
            $data['title'] = 'Users Create';
            $data['create'] = 1;
            $data['userType'] = CorporateUserType::all();
            $data['branch'] = Branch::where('org_id',$corporate[0]->org_id)->get();
            
            return view('corporate.user.form',$data);
        }else{
            return redirect()->route('corporate.dashboard');
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
            'name' => 'required',
            'email' => ['required','unique:corporates','email'],
            'password' => 'required'
        ]);

        $user = new CorporateUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->corporate_user_Type_Id = $request->corporate_user_Type_Id;
        $user->org_id = $request->org_id;
        $user->branch_id = $request->branch_id;
        $user->approverOrConsent = $request->approverOrConsent;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/userPhoto';
            $user->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$user->photo);
        }
        $user->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('corporateUser.index');
    }
    public function corporateStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required','unique:corporates','email'],
            'password' => 'required'
        ]);

        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();

        $user = new CorporateUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->corporate_user_Type_Id = $request->corporate_user_Type_Id;
        $user->org_id = $corporate[0]->org_id;
        $user->branch_id = $request->branch_id;
        $user->approverOrConsent = $request->approverOrConsent;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/userPhoto';
            $user->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$user->photo);
        }
        $user->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('corporate.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'ss';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'Users Edit';
        $data['create'] = 0;
        $data['corporateUser'] = CorporateUser::findOrFail($id);
        $data['userType'] = CorporateUserType::all();
        $data['organization'] = Organization::where('status',1)->get();

        return view('admin.corporateuser.form',$data);
    }
    public function corporateEdit($id)
    {
        $data['title'] = 'Users Edit';
        $data['create'] = 0;
        $data['corporateUser'] = CorporateUser::findOrFail($id);
        $data['userType'] = CorporateUserType::all();
        $corporate = Corporate::where('id',Auth::guard('corporate')->id())->get();
        $data['branch'] = Branch::where('org_id',$corporate[0]->org_id)->get();

        return view('corporate.user.form',$data);
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
        $request->validate([
            'name' => 'required',
            'email' => ['required','email'],
            'password' => 'required'
        ]);

        $user = CorporateUser::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->corporate_user_Type_Id = $request->corporate_user_Type_Id;
        $user->org_id = $request->org_id;
        $user->approverOrConsent = $request->approverOrConsent;
        $user->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('corporateuser.index');
    }

    public function corporateUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required','email']
        ]);

        $user = CorporateUser::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->corporate_user_Type_Id = $request->corporate_user_Type_Id;
        $user->branch_id = $request->branch_id;
        $user->approverOrConsent = $request->approverOrConsent;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/userPhoto';
            $user->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$user->photo);
        }
        $user->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('corporate.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CorporateUser::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('corporateuser.index');
    }
    public function corporateDestroy($id)
    {
        CorporateUser::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('corporate.user.index');
    }
}
