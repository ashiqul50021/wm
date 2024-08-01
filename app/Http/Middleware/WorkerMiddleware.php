<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerMiddleware
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
        if(Auth::guard('worker')->check()){
            if(Auth::guard('worker')->user()->role == "7" || Auth::guard('worker')->user()->role == "2"){
                if(!Auth::guard('worker')->user()->role == "7" && !Auth::guard('worker')->user()->role == "2"){
                    return redirect()->route('worker.login_form')->with('error','Plz login First');
                }
            }else if(Auth::guard('web')->user()){
                abort(404);
            }else{
                abort(404);
            }
        }else{
            return redirect()->route('worker.login_form');
        }
        return $next($request);
    }
}
