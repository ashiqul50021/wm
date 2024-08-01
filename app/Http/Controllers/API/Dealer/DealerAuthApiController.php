<?php

namespace App\Http\Controllers\API\Dealer;

use App\Models\User;
use App\Models\Dealer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class DealerAuthApiController extends Controller
{

    public function dealerApply(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:255', 'unique:users'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address'       => 'required',
            'bank_name'     => 'nullable',
            'bank_account'  => 'nullable',
            'profile_image' => 'required',
            'nid'               => 'nullable',
            'bank_account_img'  => 'nullable',
            'trade_license'     => 'nullable',
            'description'       => 'nullable',
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        if ($request->hasFile('profile_image')) {
            $image_profile = $request->file('profile_image');
            $name_gen1 = hexdec(uniqid()) . '.' . $image_profile->getClientOriginalExtension();
            Image::make($image_profile)->resize(300, 300)->save('upload/dealer_images/' . $name_gen1);
            $profile_image = 'upload/dealer_images/' . $name_gen1;
        } else {
            $profile_image = '';
        }

        if ($request->hasfile('shop_image')) {
            $image = $request->file('shop_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/dealer_images/' . $name_gen);
            $shop_image = 'upload/dealer_images/' . $name_gen;
        } else {
            $shop_image = '';
        }

        if ($request->hasFile('bank_information')) {
            $image_info = $request->file('bank_information');
            $name_gen_info = hexdec(uniqid()) . '.' . $image_info->getClientOriginalExtension();
            Image::make($image_info)->resize(300, 300)->save('upload/dealer_images/' . $name_gen_info);
            $bank_information = 'upload/dealer_images/' . $name_gen_info;
        } else {
            $bank_information = '';
        }

        if ($request->hasFile('nid')) {
            $image_nid = $request->file('nid');
            $name_gen_nid = hexdec(uniqid()) . '.' . $image_nid->getClientOriginalExtension();
            Image::make($image_nid)->resize(300, 300)->save('upload/dealer_images/' . $name_gen_nid);
            $nid = 'upload/dealer_images/' . $name_gen_nid;
        } else {
            $nid = '';
        }

        if ($request->hasFile('trade_license')) {
            $image_trade = $request->file('trade_license');
            $name_gen_trade = hexdec(uniqid()) . '.' . $image_trade->getClientOriginalExtension();
            Image::make($image_trade)->resize(300, 300)->save('upload/dealer_images/' . $name_gen_trade);
            $trade_license = 'upload/dealer_images/' . $name_gen_trade;
        } else {
            $trade_license = '';
        }

        $userEmail = User::where('email', $request->email)->first();
        $userPhone = User::where('phone', $request->phone)->first();
        if ($userEmail) {
            $notification = array(
                'message' => 'Dealer email already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } elseif ($userPhone) {
            $notification = array(
                'message' => 'Dealer Phone already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $user = User::create([
                'name'              => $request->name,
                'profile_image'     => $profile_image,
                'username'          => $slug,
                'email'             => $request->email,
                'address'           => $request->address,
                'phone'             => $request->phone,
                'password'          => Hash::make($request->password),
                'role'              => 6,
                'status'            => $request->status ? 1 : 0,
                'is_approved'       => 0,
            ]);
        }
        event(new Registered($user));

        $dealer = Dealer::create([
            'name'                  => $request->name,
            'user_id'               => $user->id,
            'shop_name'             => $request->shop_name,
            'address'               => $request->address,
            'description'           => $request->description,
            'bank_name'             => $request->bank_name,
            'bank_account'          => $request->bank_account,
            'profile_image'         => $profile_image,
            'bank_account_img'      => $bank_information,
            'shop_image'            => $shop_image,
            'nid'                   => $nid,
            'trade_license'         => $trade_license,
            'google_map_url'        => $request->google_map_url,
            'status'                => 0,
            // 'created_by'            => $user->id,
            'created_at'        => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Application submitted successfully! Please wait for admin approval',
            'user' => $user,
            'dealer' => $dealer,
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validation = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('dealer-api')->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (Auth::guard('dealer-api')->user()->role == "6" || Auth::guard('dealer-api')->user()->role == "1") {
                if (Auth::guard('dealer-api')->user()->is_approved == 1) {
                    $user = Auth::guard('dealer-api')->user();
                    $token = $user->createToken('MyApp')->plainTextToken;
                    return response()->json([
                        'message' => 'Dealer Login Successfully!',
                        'token' => $token,
                        'dealer' => $user,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Your account is not activated! Please Contact with Admin.',
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Invalid Email Or Password.',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Invalid Email Or Password.',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}