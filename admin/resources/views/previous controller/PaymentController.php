<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Payment View';
        $getData = Payment::all();
        return view('admin.payments.index',compact('title','getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Payment Create';
        $create = 1;
        return view('admin.payments.form',compact('title','create'));
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
            'Method' => 'required'
        ]);

        $payment = new Payment();
        $payment->Method = $request->Method;
        $payment->save();

        Session::flash('message','Successfully Created');
        return redirect()->route('payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $data['title'] = 'Payment Edit';
        $data['create'] = 0;
        $data['payment'] = Payment::findOrFail($payment);
        return view('admin.payments.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $request->validate([
            'Method' => 'required'
        ]);

        $payment = Payment::findOrFail($id);
        $payment->Method = $request->Method;
        $payment->save();

        Session::flash('message','Successfully Updated');
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();

        Session::flash('message','Successfully Deleted');
        return redirect()->route('payments.index');
    }
}
