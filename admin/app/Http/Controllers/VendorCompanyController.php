<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\ServiceType;
use App\VendorCompany;
use App\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VendorCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->branch_id == 0){
            $data['title'] = 'Vendors View';
            $data['getData'] = VendorCompany::where('org_id',Auth::user()->org_id)->orderByDesc('id')->get();

            return view('vendorCompany.index',$data);
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
            $data['title'] = 'Vendor Create';
            $data['create'] = 1;
            $data['serviceType'] = ServiceType::where('org_id',Auth::user()->org_id)->orderByDesc('id')->get();            
            return view('vendorCompany.form',$data);
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
            'email' => ['required','unique:vendors_companies','email'],
            'password' => 'required|confirmed|min:5'
        ]);

        $vendorCompany = new VendorCompany();
        $vendorCompany->name = $request->name;
        $vendorCompany->email = $request->email;
        $vendorCompany->password = bcrypt($request->password);
        $vendorCompany->save();

        if(!is_null($vendorCompany->id)){
            foreach($request->service_id as $value){
                $vendorService = new VendorService();
                $vendorService->vendor_compnay_id = $vendorCompany->id;
                $vendorService->service_type_id = $value;

                $vendorService->save();
            }
        }

        Session::flash('message','Successfully Created');
        return redirect()->route('vendor-company.index');
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
