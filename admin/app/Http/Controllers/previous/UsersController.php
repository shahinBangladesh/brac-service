<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserType;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Users View';
        $getData = User::with('userType')->with('createdBy')->orderby('id','DESC')->get();
        return view('admin.users.index',compact('title','getData'));
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
        $data['userType'] = UserType::all();
        return view('admin.users.form',$data);
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
            'email' => ['nullable','unique:users','email'],
            'password' => 'required',
            'phone' => ['nullable','unique:users'],
            'photo'=>'image|mimes:jpg,jpeg,png'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->position = $request->position;
        $user->status = $request->status;
        $user->position = $request->position;
        $user->user_Type_Id = $request->user_Type_Id;
        $user->phone = $request->phone;
        $user->EID = $request->eid;
        $user->NID = $request->nid;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/userPhoto';
            $user->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$user->photo);
        }
        $user->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('users.index');
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
        $data['users'] = User::findOrFail($id);
        $data['userType'] = UserType::all();
        return view('admin.users.form',$data);
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
            'email' => 'nullable|unique:users,email,' . $id,
            'phone' => 'nullable|unique:users,phone,' . $id,
            'password' => 'confirmed',
            'photo'=>'image|mimes:jpg,jpeg,png'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->position = $request->position;
        $user->status = $request->status;
        $user->position = $request->position;
        $user->user_Type_Id = $request->user_Type_Id;
        $user->phone = $request->phone;
        $user->EID = $request->eid;
        $user->NID = $request->nid;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $destinationPath = 'image/userPhoto';
            $user->photo = $file->getClientOriginalName();
            $file->move($destinationPath,$user->photo);
        }
        $user->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('users.index');
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
        return redirect()->route('users.index');
    }
}
