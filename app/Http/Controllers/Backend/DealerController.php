<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\DealerRequest;
use App\Models\DealerRequestDueProduct;
use App\Models\User;
use Image;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Carbon;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('38', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealers = Dealer::latest()->get();

            return view('backend.dealer.index', compact('dealers'));
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    public function DealerAllRequest()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('42', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $all_requests = DealerRequest::latest()->paginate(20);
            return view('backend.sales.all_request', compact('all_requests'));
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    public function showDealerRequest($id)
    {
        $dealer = DealerRequest::findOrFail($id);
        $requestedProducts = $dealer->dealer_request_products;
        // dd($products);
        return view('backend.sales.all_request_show', compact('dealer', 'requestedProducts'));
    }

    public function destroyDealerRequest($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('44', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealer_request = DealerRequest::findOrFail($id);
            $dealer_request->dealer_request_products()->delete();
            $dealer_request->delete();
            $notification = array(
                'message' => 'Order Request Deleted Successfully.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('39', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            return view('backend.dealer.create');
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
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
        // dd($request->all());
        $this->validate($request, [
            'name'              => 'required',
            'phone'             => ['required', 'regex:/(\+){0,1}(88){0,1}01(3|4|5|6|7|8|9)(\d){8}/', 'min:11', 'max:15'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address'           => 'required',
            'bank_name'         => 'nullable',
            'bank_account'      => 'nullable',
            'profile_image'     => 'required',
            'nid'               => 'nullable',
            'bank_account_img'  => 'nullable',
            'trade_license'     => 'nullable',
            'description'       => 'nullable',
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->hasfile('profile_image')) {
            $image = $request->file('profile_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/dealer_images/' . $name_gen);
            $profile_image = 'upload/dealer_images/' . $name_gen;
        } else {
            $profile_image = '';
        }

        if ($request->hasfile('bank_account_img')) {
            $image = $request->file('bank_account_img');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/dealer_images/' . $name_gen);
            $bank_account_img = 'upload/dealer_images/' . $name_gen;
        } else {
            $bank_account_img = '';
        }
        if ($request->hasfile('shop_image')) {
            $image = $request->file('shop_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/dealer_images/' . $name_gen);
            $shop_image = 'upload/dealer_images/' . $name_gen;
        } else {
            $shop_image = '';
        }

        if ($request->hasfile('nid')) {
            $image = $request->file('nid');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/dealer_images/' . $name_gen);
            $nid = 'upload/dealer_images/' . $name_gen;
        } else {
            $nid = '';
        }

        if ($request->hasfile('trade_license')) {
            $image = $request->file('trade_license');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/dealer_images/' . $name_gen);
            $trade_license = 'upload/dealer_images/' . $name_gen;
        } else {
            $trade_license = '';
        }

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        $role = 6;
        $user = User::create([
            'name'          => $request->name,
            'username'      => $slug,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'profile_image' => $profile_image,
            'password'      => Hash::make($request->password),
            'status'        => $request->status ? 1 : 0,
            'is_approved'   => 0,
            'created_by'    => Auth::guard('admin')->user()->id,
            'role'          => $role,
        ]);

        Dealer::insert([
            'name'              => $request->name,
            'user_id'           => $user->id,
            'shop_name'         => $request->shop_name,
            'bank_name'         => null,
            'bank_account'      => null,
            'description'       => $request->description,
            'profile_image'     => $profile_image,
            'bank_account_img'  => null,
            'shop_image'        => $shop_image,
            'nid'               => $nid,
            'trade_license'     => $trade_license,
            'google_map_url'    => $request->google_map_url,
            'status'            => $request->status ? 1 : 0,
            'created_by'        => Auth::guard('admin')->user()->id,
            'created_at'        => Carbon::now(),
        ]);

        Session::flash('success', 'Dealer Inserted Successfully');
        return redirect()->route('dealer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('38', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealer = Dealer::findOrFail($id);
            return view('backend.dealer.show', compact('dealer'));
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('40', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealer = Dealer::findOrFail($id);
                return view('backend.dealer.edit', compact('dealer'));
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
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
        // dd($request->all());
        $this->validate($request, [
            'name'              => 'required',
            'address'           => 'required',
            'bank_name'         => 'nullable',
            'bank_account'      => 'nullable',
            // 'profile_image'     => 'required',
            'nid'               => 'nullable',
            'bank_account_img'  => 'nullable',
            'trade_license'     => 'nullable',
            'description'       => 'nullable',
        ]);

        $dealer = Dealer::find($id);
        $user = User::find($dealer->user_id);

        if ($request->phone == $user->phone) {
            $phone = $user->phone;
        } else {
            $dealer_phone = User::where('phone', $request->phone)->first();
            if (!$dealer_phone) {
                $phone = $request->phone;
            } else {
                $notification = array(
                    'message' => 'The phone has already been taken.',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
        }

        if ($request->email == $user->email) {
            $email = $user->email;
        } else {
            $dealer_email = User::where('email', $request->email)->first();
            if (!$dealer_email) {
                $email = $request->email;
            } else {
                $notification = array(
                    'message' => 'The email has already been taken.',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
        }

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        $user->name = $request->name;
        $user->username = $slug;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->status = $request->status ? 1 : 0;
        $user->is_approved = 0;
        $user->save();

        // dealer table update
        $dealer->name = $request->name;
        $dealer->shop_name = $request->shop_name;
        $dealer->user_id = $user->id;
        $dealer->bank_name = $request->bank_name;
        $dealer->bank_account = $request->bank_account;
        $dealer->description = $request->description;
        $dealer->google_map_url = $request->google_map_url;
        $dealer->status = $request->status ? 1 : 0;
        $dealer->created_at = Carbon::now();
        $dealer->created_by = Auth::guard('admin')->user()->id;

        $dealer->save();

        //Shop Profile Photo Update
        if ($request->hasfile('profile_image')) {
            try {
                if (file_exists($dealer->profile_image)) {
                    unlink($dealer->profile_image);
                }
            } catch (Exception $e) {
            }
            $profile_image = $request->profile_image;
            $shop_pro = time() . $profile_image->getClientOriginalName();
            $profile_image->move('upload/dealer_images/', $shop_pro);
            $dealer->profile_image = 'upload/dealer_images/' . $shop_pro;
        } else {
            $shop_pro = '';
        }

        //Shop Cover Photo Update
        if ($request->hasfile('shop_image')) {
            try {
                if (file_exists($dealer->shop_image)) {
                    unlink($dealer->shop_image);
                }
            } catch (Exception $e) {
            }
            $shop_image = $request->shop_image;
            $shop_img = time() . $shop_image->getClientOriginalName();
            $shop_image->move('upload/dealer_images/', $shop_img);

            $dealer->shop_image = 'upload/dealer_images/' . $shop_img;
        } else {
            $shop_image = '';
        }

        // Nid Card Update
        if ($request->hasfile('nid')) {
            try {
                if (file_exists($dealer->nid)) {
                    unlink($dealer->nid);
                }
            } catch (Exception $e) {
            }
            $nid = $request->nid;
            $nid_photo = time() . $nid->getClientOriginalName();
            $nid->move('upload/dealer_images/', $nid_photo);
            $dealer->nid = 'upload/dealer_images/' . $nid_photo;
        } else {
            $nid_photo = '';
        }

        // Trade License Update
        if ($request->hasfile('trade_license')) {
            try {
                if (file_exists($dealer->trade_license)) {
                    unlink($dealer->trade_license);
                }
            } catch (Exception $e) {
            }
            $trade_license = $request->trade_license;
            $trade_photo = time() . $trade_license->getClientOriginalName();
            $trade_license->move('upload/dealer_images/', $trade_photo);
            $dealer->trade_license = 'upload/dealer_images/' . $trade_photo;
        } else {
            $trade_photo = '';
        }
        $user->save();
        $dealer->save();

        Session::flash('success', 'Dealer Updated Successfully');
        return redirect()->route('dealer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('41', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);

        $dealer = Dealer::findOrFail($id);
        $user = $dealer->user_id;
        $users = User::where('id', $user)->first();
        try {
            if (file_exists($dealer->profile_image)) {
                unlink($dealer->profile_image);
            }
        } catch (Exception $e) {
        }
        try {
            if (file_exists($dealer->bank_account_img)) {
                unlink($dealer->bank_account_img);
            }
        } catch (Exception $e) {
        }
        try {
            if (file_exists($dealer->nid)) {
                unlink($dealer->nid);
            }
        } catch (Exception $e) {
        }
        try {
            if (file_exists($dealer->trade_license)) {
                unlink($dealer->trade_license);
            }
        } catch (Exception $e) {
        }

        $dealer->delete();
        $users->delete();

        $notification = array(
            'message' => 'Dealer Deleted Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
     else{
        Session::flash('error', 'You have no permission to Access the page');
        return back();
      }
    }

    /*=================== Start Active/Inactive Methoed ===================*/
    public function active($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('43', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealer = User::find($id);
            $dealer->status = 1;
            $dealer->save();

            Session::flash('success', 'Dealer Active Successfully.');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }

    }

    public function inactive($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('43', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealer = User::find($id);
            $dealer->status = 0;
            $dealer->save();

            Session::flash('warning', 'Dealer Inactive Successfully.');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }

    }
    public function approved($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('43', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $user = User::find($id);
            $user->is_approved = 1;
            $user->save();

            Session::flash('success', 'Dealer Approved Successfully.');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [

            'password'           => 'required',
            'password_confirmation'      => 'required|same:password',
        ]);
        $dealer = User::find($id);

        //  dd($hashedPassword);

            $dealer->password = bcrypt($request->password);
            $dealer->save();

            Session::flash('success', 'Password Updated Successfully');
            return redirect()->back();


    }



    public function dealerReorder()
    {
        // Retrieve dealers with role 6 and are approved
        $dealers = User::where('role', 6)->where('is_approved', 1)->get();

        // $dealerProduct = collect();

        // foreach ($dealers as $dealer) {
        //     // Retrieve due products for each dealer
        //     $dealerDueProducts = DealerRequestDueProduct::where('user_id', $dealer->id)->get();

        //     // Add the due products to the array
        //     $dealerProduct = $dealerProduct->merge($dealerDueProducts);
        // }

        // dd($dealerProduct->count());

        return view('backend.sales.all_orders.dealer_reorder', compact('dealers'));
    }



    public function dealerReorderDetails($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('45', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $dealer = User::where('role', 6)->where('is_approved', 1)->with('dealerDue')->find($id);

            return view('backend.sales.all_orders.dealer_reorder_show', compact('dealer'));
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }
}
