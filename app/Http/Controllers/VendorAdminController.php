<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\User;
use App\Models\VendorPosOrder;
use App\Models\VendorSignupRequest;
use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Session;
use Artisan;
use Illuminate\Support\Facades\DB;
use Image;
use Str;

class VendorAdminController extends Controller
{
    /*=================== Start Index Login Methoed ===================*/
    public function index()
    {

        if (Auth::check()) {
            abort(404);
        }

        return view('vendor.vendor_login');
    } // end method

    /*=================== End Index Login Methoed ===================*/

    /*=================== Start Dashboard Methoed ===================*/
    public function dashboard()
    {
        $data['vendor'] = Vendor::where('user_id', Auth::guard('vendor')->user()->id)->first();

        $data['productPriceValue'] = Product::where('vendor_id', Auth::guard('vendor')->user()->id)
        ->sum(DB::raw('purchase_price * stock_qty'));
        $data['totalProduct'] = Product::where('vendor_id',Auth::guard('vendor')->user()->id)->count();
        $data['totalCustomer'] = User::where('vendor_id',Auth::guard('vendor')->user()->id)->where('role',3)->count();
        $data['totalLowStock'] = Product::where('vendor_id',Auth::guard('vendor')->user()->id)->where('stock_qty', '<', 5)->count();
        $data['todaySele'] = VendorPosOrder::whereDay('created_at',date('d'))->count();
        // dd(VendorPosOrder::whereDay('created_at',date('Y-m-d'))->get());
        // dd(VendorPosOrder::whereYear('created_at', date('Y'))->count());
        $data['monthlySale'] = VendorPosOrder::whereMonth('created_at',date('m'))->count();
        $data['yearlySale'] = VendorPosOrder::whereYear('created_at', date('Y'))->count();
        // dd(date('y'));

        // $productCount = DB::table('products')
        //     ->select(DB::raw('count(*) as total_products'))
        //     ->where('vendor_id', Auth::guard('vendor')->user()->id)
        //     ->where('status', 1)
        //     ->where('approved', 1)
        //     ->first();

        // $categoryCount = DB::table('categories')
        //     ->select(DB::raw('count(*) as total_categories'))
        //     ->where('status', 1)
        //     ->first();

        // $brandCount = DB::table('brands')
        //     ->select(DB::raw('count(*) as total_brands'))
        //     ->where('status', 1)
        //     ->first();

        // $orderCount = DB::table('orders')
        //     ->select(DB::raw('count(*) as total_orders, sum(grand_total) as total_sell'))
        //     ->first();

        // $lowStockCount = DB::table('product_stocks as s')
        //     ->leftjoin('products as p', 's.product_id', '=', 'p.id')
        //     ->select(DB::raw('count(s.id) as total_low_stocks'))
        //     ->where('p.vendor_id', Auth::guard('vendor')->user()->id)
        //     ->where('s.qty', '<=', 5)
        //     ->first();

        // dd($lowStockCount);
        // return view('vendor.index', compact('userCount', 'productCount', 'categoryCount', 'brandCount', 'orderCount', 'lowStockCount'));
        return view('vendor.index',$data);
    } // end method

    /*=================== End Dashboard Methoed ===================*/

    /*=================== Start vendor Login Methoed ===================*/
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        // dd($request->all());
        $check = $request->all();

        if (Auth::guard('vendor')->attempt(['email' => $check['email'], 'password' => $check['password']])) {

            // dd(Auth::guard('vendor'));

            if (Auth::guard('vendor')->user()->role == "2" || Auth::guard('vendor')->user()->vendor_id !== null && Auth::guard('vendor')->user()->role == "5") {
                if (Auth::guard('vendor')->user()->is_approved == 1) {
                    return redirect()->route('vendor.dashboard')->with('success', 'Vendor Login Successfully.');
                } else {
                    $notification = array(
                        'message' => 'Your account is not activated! Please Contact with Admin.',
                        'alert-type' => 'error'
                    );
                    return back()->with($notification);
                }
            } else {
                $notification = array(
                    'message' => 'Invaild Email Or Password.',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        } else {
            $notification = array(
                'message' => 'Invaild Email Or Password.',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    } // end method

    /*=================== End vendor Login Methoed ===================*/

    /*=================== Start Logout Methoed ===================*/
    public function vendorLogout(Request $request)
    {

        Auth::guard('vendor')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Vendor Logout Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('vendor.login_form')->with($notification);
    } // end method
    /*=================== End Logout Methoed ===================*/

    /*=================== Start vendorRegister Methoed ===================*/
    public function vendorRegister()
    {
        return view('vendor.vendor_register');
    } // end method
    /*=================== End vendorRegister Methoed ===================*/

    /*=================== Start vendorForgotPassword Methoed ===================*/
    public function vendorForgotPassword()
    {

        return view('vendor.vendor_forgot_password');
    } // end method
    /*=================== End vendorForgotPassword Methoed ===================*/

    /*=================== Start vendorRegisterStore Methoed ===================*/
    public function vendorRegisterStore(Request $request)
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
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $shop_profile = 'upload/vendor/' . $name_gen;
        } else {
            $shop_profile = '';
        }

        if ($request->hasfile('shop_cover')) {
            $image = $request->file('shop_cover');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $shop_cover = 'upload/vendor/' . $name_gen;
        } else {
            $shop_cover = '';
        }

        if ($request->hasfile('nid')) {
            $image = $request->file('nid');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $nid = 'upload/vendor/' . $name_gen;
        } else {
            $nid = '';
        }

        if ($request->hasfile('trade_license')) {
            $image = $request->file('trade_license');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $trade_license = 'upload/vendor/' . $name_gen;
        } else {
            $trade_license = '';
        }

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->shop_name)) . '-' . Str::random(5);
        }


        $role = 2;
        $is_approved = 0;


        $user = User::create([
            'name' => $request->shop_name,
            'username' => $slug,
            'phone' =>  $request->phone,
            'email' => $request->email,
            'address' => $request->address,

            'profile_image' => $shop_profile,
            'password' => Hash::make($request->password),
            'status' => $request->status ? 1 : 0,
            'is_approved' => $is_approved,
            'created_by' => null,
            'role' => $role,
        ]);

        Vendor::insert([
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


        // dd($request->all());

        return redirect()->route('vendor.login_form')->with('warning', 'Vendor Registation Successfully! waiting for admin approval!.');
    } // end method
    /*=================== End vendorRegisterStore Methoed ===================*/

    /* =============== Start Profile Method ================*/
    public function Profile()
    {
        $id = Auth::guard('vendor')->user()->id;
        $vendorData = Vendor::where('user_id', $id)->with('user')->first();

        // dd($vendorData);
        return view('vendor.vendor_profile_view', compact('vendorData'));
    } // End Method

    /* =============== Start EditProfile Method ================*/
    public function editProfile()
    {

        $id = Auth::guard('vendor')->user()->id;
        $editData = Vendor::where('user_id', $id)->with('user')->first();
        return view('vendor.vendor_profile_edit', compact('editData'));
    } //

    /* =============== Start StoreProfile Method ================*/
    public function storeProfileUpdate(Request $request)
    {
        $id = Auth::guard('vendor')->user()->id;
        $data = Vendor::where('user_id', $id)->with('user')->first();
        $data->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        $data->shop_name = $request->name;
        $data->address = $request->address;

        if ($request->hasfile('profile_image')) {
            try {
                if (file_exists($data->shop_profile)) {
                    unlink($data->shop_profile);
                }
            } catch (Exception $e) {
            }
            $shop_profile = $request->profile_image;
            $shop_pro = time() . $shop_profile->getClientOriginalName();
            $shop_profile->move('upload/vendor/', $shop_pro);

            $data->shop_profile = 'upload/vendor/' . $shop_pro;
            $data->user->profile_image = 'upload/vendor/' . $shop_pro;
        } else {
            $shop_pro = '';
        }
        $data->save();

        Session::flash('success', 'Vendor Profile Updated Successfully');

        return redirect()->route('vendor.profile');
    } // End Method

    /* =============== Start ChangePassword Method ================*/
    public function changePassword()
    {

        return view('vendor.vendor_change_password');
    } //

    /* =============== Start UpdatePassword Method ================*/
    public function updatePassword(Request $request)
    {

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::guard('vendor')->user()->password;

        // dd($hashedPassword);
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $id = Auth::guard('vendor')->user()->id;
            $vendor = User::find($id);
            $vendor->password = bcrypt($request->newpassword);
            $vendor->save();

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

    /* =============== End clearCache Method ================*/
}
