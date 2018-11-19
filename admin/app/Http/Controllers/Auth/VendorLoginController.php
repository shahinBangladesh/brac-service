<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Auth;

class VendorLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:vendorPanel');
    }

    public function showLoginForm()
    {
      return view('auth.vendors-login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required'
      ]);

      // Attempt to log the user in
      if (Auth::guard('vendorPanel')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('vendor.dashboard'));
      }

      // if unsuccessful, then redirect back to the login with the form data
      Session::flash('message','Emails or Password are invalid');
      return redirect()->back()->withInput($request->only('email'));
    }
}

