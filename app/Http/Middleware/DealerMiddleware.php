<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class DealerMiddleware
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
        if(Auth::guard('dealer')->check()){
            if(Auth::guard('dealer')->user()->role == "6" || Auth::guard('dealer')->user()->role == "2"){
                if(!Auth::guard('dealer')->user()->role == "6" && !Auth::guard('dealer')->user()->role == "2"){
                    return redirect()->route('dealer.login_form')->with('error','Plz login First');
                }
            }else if(Auth::guard('web')->user()){
                abort(404);
            }else{
                abort(404);
            }
        }else{
            return redirect()->route('dealer.login_form');
        }
        return $next($request);
    }
}
