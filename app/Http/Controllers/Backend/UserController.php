<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('94', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            if (Auth::guard('admin')->user()->role != '1' &&
            !in_array('94', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            abort(404);
        }
            $customers = User::where('role', 3)->where('vendor_id', NULL)->latest()->get();
            return view('backend.customer.index', compact('customers'));
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    public function outCustomer()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('95', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            if (Auth::guard('admin')->user()->role != '1' &&
                !in_array('95', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
                abort(404);
            }
            $customers = User::where('role', 8)->latest()->get();
            return view('backend.customer.out_customer', compact('customers'));
        } else {
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
        if (Auth::guard('admin')->user()->role == '1' || in_array('99', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            return view('backend.customer.create');
        } else {
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
        $request->validate([
            // 'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->hasfile('profile_image')) {
            $image = $request->file('profile_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/user/' . $name_gen);
            $profile_image = 'upload/user/' . $name_gen;
        } else {
            $profile_image = '';
        }


        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        $role = 3;
        // if ($request->password !== $request->confirm_password) {
        //     Session::flash('warning', 'Password do not match!');
        //     return redirect()->back();
        // }
        User::create([
            'role'          => $role,
            'name'          => $request->name,
            'username'      =>  $slug,
            'address'       => $request->address,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'profile_image' => $profile_image,
            'password'      => Hash::make('12345678'),
            'status'        => $request->status ? 1 : 0,
            'is_approved'   => 1,
        ]);

        Session::flash('success', 'User Inserted Successfully');
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('101', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {


                    $customer = User::find($id);
                    return view('backend.customer.show', compact('customer'));
        }else{
            Session::flash('error', 'you Can not access the page');
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
        if (Auth::guard('admin')->user()->role == '1' || in_array('100', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) || in_array('97', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {

            $data['customer'] = User::find($id);
            return view('backend.customer.edit', $data);
        }else{
            Session::flash('error', 'you Can not access the page');
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
        $request->validate([
            // Validation rules for update if needed
        ]);

        $user = User::findOrFail($id);

        if ($request->hasfile('profile_image')) {
            $image = $request->file('profile_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/user/' . $name_gen);
            $profile_image = 'upload/user/' . $name_gen;
            $user->update(['profile_image' => $profile_image]);
        }

        $user->update([
            'name'          => $request->name,
            'address'       => $request->address,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'status'        => $request->status ? 1 : 0,
        ]);

        if (!empty($request->password)) {
            if ($request->password !== $request->confirm_password) {
                Session::flash('warning', 'Password does not match!');
                return redirect()->back();
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        if ($user->role == 8) {
            Session::flash('success', 'User updated successfully');
            return redirect()->route('outCustomer');
        } elseif ($user->role == 3) {
            Session::flash('success', 'User updated successfully');
            return redirect()->route('customer.index');
        } else {
            Session::flash('success', 'User updated successfully');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customerDelete($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('102', json_decode(Auth::guard('admin')->user()->staff->role->permissions)) || in_array('98', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {


            // dd('joy bangla');
            $customer = User::find($id);
            if (file_exists($customer->profile_image)) {
                unlink($customer->profile_image);
            }
            if ($customer->orders()) {
                $customer->orders()->delete();
            }
            $customer->delete();
            Session::flash('success', 'Customer Deleted Successfully');
            return redirect()->back();
        }else{
            Session::flash('error', 'you Can not access the page');
            return back();
        }
    }
}
