<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminApiMiddleware
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
        try {
            $user = auth()->guard('admin-api')->user();
            dd($user);

            if (!$user || $user->role !== "1") {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Pass the user to the request for later use
            $request->merge(['admin-user' => $user]);

            return $next($request);
        } catch (\Throwable $e) {
            // Catch any exception thrown during authentication
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
}
