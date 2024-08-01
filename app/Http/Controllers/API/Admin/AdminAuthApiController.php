<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthApiController extends Controller
{
    public function AdminLogin(Request $request)
{
    $input = $request->all();
    $validation = Validator::make($input, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validation->fails()) {
        return response(['error' => $validation->errors()], 422);
    }

    if (Auth::guard('admin-api')->attempt(['email' => $input['email'], 'password' => $input['password']])) {
        $user = Auth::guard('admin-api')->user();
        $token = $user->createToken('MyApp', ['admin-api'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'Admin Successfully Login',
        ]);
    } else {
        return response()->json([
            'error' => 'Email or password does not match',
        ], 401);
    }
}
}
