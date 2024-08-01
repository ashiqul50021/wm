<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('seller')->check()) {
            if (Auth::guard('seller')->user()->role == "9" || Auth::guard('seller')->user()->role == "9") {
                if (!Auth::guard('seller')->user()->role == "9" && !Auth::guard('seller')->user()->role == "9") {
                    return redirect()->route('seller.login_form')->with('error', 'Plz login First');
                }
            } else if (Auth::guard('web')->user()) {
                abort(404);
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('seller.login_form');
        }
        return $next($request);
    }
}
