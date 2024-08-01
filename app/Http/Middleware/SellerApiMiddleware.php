<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerApiMiddleware
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
        if (Auth::guard('seller-api')->check()) {
            $user = Auth::guard('seller-api')->user();

            if ($user->role == "9") {
                return $next($request);
            } else {
                return redirect()->route('sellerLogin')->with('error', 'Please login with valid credentials');
            }
        } else {
            return redirect()->route('sellerLogin');
        }
    }
}
