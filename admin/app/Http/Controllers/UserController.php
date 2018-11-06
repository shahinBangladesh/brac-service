<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\User;
use App\UserType;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->branch_id == 0){
            $title = 'Users View';
            $getData = User::where('org_id',Auth::user()->org_id)->orderByDesc('id')->get();
            return view('user.index',compact('title','getData'));
        }else{
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->branch_id == 0){
            $data['title'] = 'Users Create';
            $data['create'] = 1;
            $data['userType'] = UserType::where('org_id',Auth::user()->org_id)->orderByDesc('id')->get();
            $data['branch'] = Branch::where('org_id',Auth::user()->org_id)->orderByDesc('id')->get();
            
            return view('user.form',$data);
        }else{
            return redirect()->route('dashboard');
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
            'email' => ['required','unique:users','email'],
            'password' => 'required|confirmed|min:6'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->user_type_id = $request->corporate_user_Type_Id;
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
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'sss';
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
        $data['corporateUser'] = User::findOrFail($id);
        $data['userType'] = UserType::all();
        $data['branch'] = Branch::where('org_id',Auth::user()->org_id)->get();

        return view('user.form',$data);
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
            'email' => ['required','email']
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        
        @if($request->has('password') && !is_null($request->password))
            $user->password = bcrypt($request->password);

        $user->user_type_id = $request->corporate_user_Type_Id;
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
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('user.index');
    }
    public function corporateDestroy($id)
    {
        User::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('user.index');
    }
}
