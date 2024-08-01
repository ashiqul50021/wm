<?php

namespace App\Http\Controllers\API\Seller;

use Str;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Seller\SellerAuthApiResource;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

class SellerAuthApiController extends Controller
{
    public function sellerRegisterStore(Request $request)
    {

        // dd($request->all());
        $this->validate($request, [
            'shop_name'     => 'required',
            'phone'         => ['required', 'regex:/(\+){0,1}(88){0,1}01(3|4|5|6|7|8|9)(\d){8}/', 'min:11', 'max:15'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address'       => 'required',
            'shop_profile'  => 'required',
            'shop_cover'    => 'required',
            'password'      => ['required', 'string', 'min:5', 'confirmed'],
        ]);


        if ($request->hasfile('shop_profile')) {
            $image = $request->file('shop_profile');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $shop_profile = 'upload/seller_images/' . $name_gen;
        } else {
            $shop_profile = '';
        }

        if ($request->hasfile('shop_cover')) {
            $image = $request->file('shop_cover');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $shop_cover = 'upload/seller_images/' . $name_gen;
        } else {
            $shop_cover = '';
        }

        if ($request->hasfile('nid')) {
            $image = $request->file('nid');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $nid = 'upload/seller_images/' . $name_gen;
        } else {
            $nid = '';
        }

        if ($request->hasfile('trade_license')) {
            $image = $request->file('trade_license');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $trade_license = 'upload/seller_images/' . $name_gen;
        } else {
            $trade_license = '';
        }

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->shop_name)) . '-' . 'Str'::random(5);
        }


        $role = 9;
        $is_approved = 0;


        $user = User::create([
            'name' => $request->shop_name,
            'username' => $slug,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'profile_image' => $shop_profile,
            'password' => Hash::make($request->password),
            'status' => $request->status ? 1 : 0,
            'is_approved' => $is_approved,
            'created_by' => null,
            'role' => $role,
        ]);

        if ($user) {
            $seller = Seller::create([
                'shop_name' => $request->shop_name,
                'slug' => $slug,
                'user_id' => $user->id,
                'address' => $request->address,
                'commission' => $request->commission ?? '',
                'description' => $request->description,
                'shop_profile' => $shop_profile,
                'shop_cover' => $shop_cover,
                'nid' => $nid,
                'google_map_url' => $request->google_map_url,
                'trade_license' => $trade_license,
                'status' => $request->status ? 1 : 0,
                'created_by' => null,
            ]);
            // dd($seller->id);
            if ($seller) {
                $user->update(['seller_id' => $seller->id]);
                $user->save();
            } else {
                return back()->with('error', 'No seller found');
            }
        }

        return response()->json([
            'message' => 'Seller Registration Successfully! Waiting for admin approval!',
            // 'data' =>  SellerAuthApiResource::collection([$user, $seller]),
            'user' => $user,
            'seller' => $seller,
        ], 200);
    } // end method


    public function sellerLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('seller-api')->attempt($credentials)) {
            $user = Auth::guard('seller-api')->user();

            if ($user->role == '9') {
                if ($user->is_approved == 1) {
                    $token = $user->createToken('Seller Token')->plainTextToken;

                    return response()->json([
                     'token' => $token,
                     'message' => 'Seller Login Successfully',
                     'user' => $user,
                    ]);
                } else {
                    return response()->json(['message' => 'Your account is not activated! Please contact the admin.'], 401);
                }
            } else {
                return response()->json(['message' => 'Invalid Email or Password.'], 401);
            }
        }

        throw ValidationException::withMessages(['email' => 'Invalid Email or Password.']);
    }
}
