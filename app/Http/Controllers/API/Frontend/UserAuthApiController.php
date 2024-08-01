<?php

namespace App\Http\Controllers\API\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserAuthApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $userEmail = User::where('email', $request->email)->first();
        $userUser = User::where('username', $request->username)->first();
        $userPhone = User::where('phone', $request->phone)->first();

        if ($userEmail) {
            return response()->json([
                'message' => 'User email already Created!',
            ], 200);
        } elseif ($userUser) {
            return response()->json([
                'message' => 'User name already Created!',
            ], 200);
        } elseif ($userPhone) {
            return response()->json([
                'message' => 'User phone already Created!',
            ], 200);
        } else {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
        }
        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'User Created Successfully.',
            'data' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['user'] =  $user;

            return response()->json([
                'message' => 'User Login Successfully!',
                'token' => $success['token'],
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid Credentials!',
            ], 404);
        }
    }
}
