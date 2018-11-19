<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VendorPanel
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
        if(Auth::guard('vendorPanel')->check()){
            return $next($request);
        }
        return redirect()->route('vendor.login');
    }
}
