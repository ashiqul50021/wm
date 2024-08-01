<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;
use Str;

class SellerController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            abort(404);
        }

        return view('seller.seller_login');
    } // end method
    public function sellerRegister()
    {
        return view('seller.seller_register');
    } // end method

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


        if ($request->hasFile('shop_profile')) {
            $image = $request->file('shop_profile');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $shop_profile = 'upload/seller_images/' . $name_gen;
        } else {
            $shop_profile = '';
        }

        if ($request->hasFile('shop_cover')) {
            $image = $request->file('shop_cover');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $shop_cover = 'upload/seller_images/' . $name_gen;
        } else {
            $shop_cover = '';
        }

        if ($request->hasFile('nid')) {
            $image = $request->file('nid');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $nid = 'upload/seller_images/' . $name_gen;
        } else {
            $nid = '';
        }

        if ($request->hasFile('trade_license')) {
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
                $user->seller_id = $seller->id;
                $user->save();
            } else {
               return back()->with('error', 'No seller found');
            }
        }

        // dd($request->all());

        return redirect()->route('seller.login_form')->with('warning', 'Seller Registration Successfully! waiting for admin approval!.');
    } // end method

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        // dd($request->all());
        $check = $request->all();

        if (Auth::guard('seller')->attempt(['email' => $check['email'], 'password' => $check['password']])) {

            // dd(Auth::guard('seller'));

            if (Auth::guard('seller')->user()->role == "9") {
                if (Auth::guard('seller')->user()->is_approved == 1) {
                    return redirect()->route('seller.dashboard')->with('success', 'Seller Login Successfully.');
                } else {
                    $notification = array(
                        'message' => 'Your account is not activated! Please Contact with Admin.',
                        'alert-type' => 'error'
                    );
                    return back()->with($notification);
                }
            } else {
                $notification = array(
                    'message' => 'Invalid Email Or Password.',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        } else {
            $notification = array(
                'message' => 'Invalid Email Or Password.',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    } // end method

    public function dashboard()
    {
        $data['seller'] = Seller::where('user_id', Auth::guard('seller')->user()->id)->first();
        $data['products'] = Product::where('seller_id', Auth::guard('seller')->user()->id)->latest()->get();

        return view('seller.index',$data);
    } // end method

    public function Profile()
    {
        $id = Auth::guard('seller')->user()->id;
        $sellerData = Seller::where('user_id', $id)->with('user')->first();

        // dd($vendorData);
        return view('seller.seller_profile_view', compact('sellerData'));
    } // End Method

    /* =============== Start EditProfile Method ================*/
    public function editProfile()
    {

        $id = Auth::guard('seller')->user()->id;
        $editData = Seller::where('user_id', $id)->with('user')->first();
        return view('seller.seller_profile_edit', compact('editData'));
    } //

    /* =============== Start StoreProfile Method ================*/
    public function storeProfile(Request $request)
    {
        $id = Auth::guard('seller')->user()->id;
        $data = Seller::where('user_id', $id)->with('user')->first();
        $data->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        $data->shop_name = $request->name;
        $data->address = $request->address;

        if ($request->hasFile('profile_image')) {
            try {
                if (file_exists($data->shop_profile)) {
                    unlink($data->shop_profile);
                }
            } catch (Exception $e) {
            }
            $shop_profile = $request->profile_image;
            $shop_pro = time() . $shop_profile->getClientOriginalName();
            $shop_profile->move('upload/seller_images/', $shop_pro);

            $data->shop_profile = 'upload/seller_images/' . $shop_pro;
            $data->user->profile_image = 'upload/seller_images/' . $shop_pro;
        } else {
            $shop_pro = '';
        }
        $data->save();

        Session::flash('success', 'Seller Profile Updated Successfully');

        return redirect()->route('seller.profile');
    } // End Method

    /* =============== Start ChangePassword Method ================*/
    public function changePassword()
    {

        return view('seller.seller_change_password');
    } //

    /* =============== Start UpdatePassword Method ================*/
    public function updatePassword(Request $request)
    {

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::guard('seller')->user()->password;

        // dd($hashedPassword);
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $id = Auth::guard('seller')->user()->id;
            $seller = User::find($id);
            $seller->password = bcrypt($request->newpassword);
            $seller->save();

            Session::flash('success', 'Password Updated Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Old password is not match');
            return redirect()->back();
        }
    } // End Method

    /* =============== Start clearCache Method ================*/
    function clearCache(Request $request)
    {
        Artisan::call('optimize:clear');
        Session::flash('success', 'Cache cleared successfully.');
        return redirect()->back();
    } // end method


    public function sellerLogout(Request $request)
    {

        Auth::guard('seller')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Seller Logout Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('seller.login_form')->with($notification);
    } // end method

}
