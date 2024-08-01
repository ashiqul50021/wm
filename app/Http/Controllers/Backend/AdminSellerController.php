<?php

namespace App\Http\Controllers\Backend;

use App\Models\Seller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Image;
use App\Http\Controllers\Controller;
use App\Models\Manufacture;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminSellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::latest()->get();

        return view('backend.seller.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.seller.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            Image::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $trade_license = 'upload/seller_images/' . $name_gen;
        } else {
            $trade_license = '';
        }

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->shop_name)) . '-' . Str::random(5);
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
            'created_by' => Auth::guard('admin')->user()->id,
            'role' => $role,
        ]);

        $seller = Seller::create([
            'shop_name' => $request->shop_name,
            'slug' => $slug,
            'user_id' => $user->id,
            'address' => $request->address,
            'commission' => $request->commission,
            'description' => $request->description,
            'shop_profile' => $shop_profile,
            'shop_cover' => $shop_cover,
            'nid' => $nid,
            'google_map_url' => $request->google_map_url,
            'trade_license' => $trade_license,
            'status' => $request->status ? 1 : 0,
            'created_by' => Auth::guard('admin')->user()->id,
        ]);
        // dd($user);
        $user->seller_id = $seller->id;
        $user->save();

        Session::flash('success', 'Seller Inserted Successfully');
        return redirect()->route('seller.index');
    }


    public function changePassowrd($id)
    {
        $seller = Seller::find($id);
        return view('backend.seller.change_password', compact('seller'));
    }

    public function updatePassword(Request $request, $id)
    {

        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        $seller = Seller::find($id);
        $user = User::where('id', $seller->user_id)->first();

        if ($request->password == $request->confirm_password) {
            // dd("milse vai");
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            Session::flash('success', 'Password Updated Successfully');
            return redirect()->back();
        } else {
            // dd("mile nai vai");
            Session::flash('error', 'Passwords do not match');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        return view('backend.seller.edit', compact('seller'));
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
        $this->validate($request, [
            'shop_name'     => 'required',
            'phone'         => ['required', 'regex:/(\+){0,1}(88){0,1}01(3|4|5|6|7|8|9)(\d){8}/', 'min:11', 'max:15'],
            'email'         => ['required', 'string', 'email', 'max:255'],
            'address'       => 'required',
        ]);

        $seller = Seller::find($id);

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->shop_name)) . '-' . Str::random(5);
        }

        if ($request->status == Null) {
            $request->status = 0;
        }

        $user = User::find($seller->user_id);
        $user->name = $request->shop_name;
        $user->username = $slug;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->is_approved = 0;
        $user->status = $request->status;

        $user->save();

        // seller table update
        $seller->shop_name = $request->shop_name;
        $seller->slug = $slug;
        $seller->address = $request->address;
        $seller->commission = $request->commission;
        $seller->description = $request->description;
        $seller->google_map_url = $request->google_map_url;
        $seller->status = $request->status;
        $seller->created_by = Auth::guard('admin')->user()->id;

        $seller->save();

        //Shop Profile Photo Update
        if ($request->hasfile('shop_profile')) {
            try {
                if (file_exists($seller->shop_profile)) {
                    unlink($seller->shop_profile);
                }
            } catch (Exception $e) {
            }
            $shop_profile = $request->shop_profile;
            $shop_pro = time() . $shop_profile->getClientOriginalName();
            $shop_profile->move('upload/seller_images/', $shop_pro);

            $seller->shop_profile = 'upload/seller_images/' . $shop_pro;
            $user->profile_image = 'upload/seller_images/' . $shop_pro;
        } else {
            $shop_pro = '';
        }

        //Shop Cover Photo Update
        if ($request->hasfile('shop_cover')) {
            try {
                if (file_exists($seller->shop_cover)) {
                    unlink($seller->shop_cover);
                }
            } catch (Exception $e) {
            }
            $shop_cover = $request->shop_cover;
            $shop_cover_photo = time() . $shop_cover->getClientOriginalName();
            $shop_cover->move('upload/seller_images/', $shop_cover_photo);

            $seller->shop_cover = 'upload/seller_images/' . $shop_cover_photo;
        } else {
            $shop_cover_photo = '';
        }

        // Nid Card Update
        if ($request->hasfile('nid')) {
            try {
                if (file_exists($seller->nid)) {
                    unlink($seller->nid);
                }
            } catch (Exception $e) {
            }
            $nid = $request->nid;
            $nid_photo = time() . $nid->getClientOriginalName();
            $nid->move('upload/seller_images/', $nid_photo);
            $seller->nid = 'upload/seller_images/' . $nid_photo;
        } else {
            $nid_photo = '';
        }

        // Trade License Update
        if ($request->hasfile('trade_license')) {
            try {
                if (file_exists($seller->trade_license)) {
                    unlink($seller->trade_license);
                }
            } catch (Exception $e) {
            }
            $trade_license = $request->trade_license;
            $trade_photo = time() . $trade_license->getClientOriginalName();
            $trade_license->move('upload/seller_images/', $trade_photo);
            $seller->trade_license = 'upload/seller_images/' . $trade_photo;
        } else {
            $trade_photo = '';
        }

        $user->save();
        $seller->save();

        Session::flash('success', 'Seller Updated Successfully');
        return redirect()->route('seller.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $user = $seller->user_id;
        $users = User::where('id', $user)->first();
        try {
            if (file_exists($seller->shop_cover)) {
                unlink($seller->shop_cover);
            }
        } catch (Exception $e) {
        }
        try {
            if (file_exists($seller->shop_profile)) {
                unlink($seller->shop_profile);
            }
        } catch (Exception $e) {
        }
        try {
            if (file_exists($seller->nid)) {
                unlink($seller->nid);
            }
        } catch (Exception $e) {
        }
        try {
            if (file_exists($seller->trade_license)) {
                unlink($seller->trade_license);
            }
        } catch (Exception $e) {
        }

        $seller->delete();

        if ($users) {
            $users->delete();
        }

        $notification = array(
            'message' => 'Seller Deleted Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /*=================== Start Active/Inactive Methoed ===================*/
    public function active($id)
    {
        $seller = Seller::find($id);
        $seller->status = 1;
        $seller->save();

        Session::flash('success', 'Seller Active Successfully.');
        return redirect()->back();
    }

    public function inactive($id)
    {
        $seller = Seller::find($id);
        $seller->status = 0;
        $seller->save();

        Session::flash('warning', 'Seller Inactive Successfully.');
        return redirect()->back();
    }
    public function approved($id)
    {
        $user = User::find($id);
        $user->is_approved = 1;
        $user->save();

        Session::flash('success', 'Seller Approved Successfully.');
        return redirect()->back();
    }
    public function inApproved($id)
    {
        $user = User::find($id);
        $user->is_approved = 0;
        $user->save();

        Session::flash('warning', 'Seller InApproved Successfully.');
        return redirect()->back();
    }

    public function productRequest(){
        $sellerProduct = Product::where('seller_id', '!=', NULL)
        ->where('approved', 0)
        ->latest()
        ->get();
        // dd($sellerProduct);
        return view('backend.seller.productRequest',compact('sellerProduct'));
    }
}
