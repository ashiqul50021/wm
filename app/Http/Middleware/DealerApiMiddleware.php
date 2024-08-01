<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealerApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {

    //     if (Auth::guard('dealer-api')->check()) {
    //         $user = Auth::guard('dealer-api')->user();

    //         if ($user->role == "6" || $user->role == "2") {
    //             // Check if the user has the correct roles
    //             if (!($user->role == "6" || $user->role == "2")) {
    //                 return response()->json([
    //                     'message' => 'Unauthorized: Invalid role',
    //                 ], 403);
    //             }
    //         } else {
    //             // Invalid role
    //             return response()->json([
    //                 'message' => 'Unauthorized: Invalid role',
    //             ], 403);
    //         }
    //     } else {
    //         // Not authenticated as dealer
    //         return response()->json([
    //             'message' => 'Unauthorized: Please log in first',
    //         ], 401);
    //     }

    //     return $next($request);
    // }

    // public function handle(Request $request, Closure $next)
    // {
    //     if (Auth::guard('sanctum')->check()) {
    //         $user = Auth::guard('sanctum')->user();

    //         if ($user->role == 6) {
    //             return $next($request);
    //         } else {
    //             return response()->json(['error' => 'Permission Not Allowed!'], 403);
    //         }
    //     } else {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }
    // }

    // DealerApiMiddleware
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::guard('dealer-api')->check()) {
        //     $user = Auth::guard('dealer-api')->user();

        //     if ($user->role == 6) {
        //         return $next($request);
        //     } else {
        //         return response()->json(['error' => 'Permission Not Allowed!'], 403);
        //     }
        // } else {
        //     return response()->json(['error' => 'Unauthenticateddddd.'], 401);
        // }

        try {
            $user = auth()->guard('dealer-api')->user();
            //dd($user);

            if (!$user || $user->role !== "1") {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Pass the user to the request for later use
            $request->merge(['dealer-user' => $user]);

            return $next($request);
        } catch (\Throwable $e) {
            // Catch any exception thrown during authentication
            return response()->json(['error' => 'Unauthenticated-ffff'], 401);
        }
    }
}