<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Manufacture;
use App\Models\ManufactureLedger;
use App\Models\ManufacturePrice;
use App\Models\User;
use App\Models\WorkerBalance;
use App\Models\WorkerSignupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Image;
use Illuminate\Support\Str;

class WorkerAdminController extends Controller
{
    /*
    |-----------------------------------------------------------------------------
    | INDEX (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function index()
    {
        if (Auth::check()) {
            abort(404);
        }
        return view('worker.worker_login');
    }

    /*
    |-----------------------------------------------------------------------------
    | REGISTRATION (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function register()
    {
        if (Auth::check()) {
            abort(404);
        }
        return view('worker.worker_register');
    }


    public function storeSignupRequest(Request $request)
    {
        // dd($request->all());
        // dd($request->hasFile('profile_image'));
        $request->validate([
            'name'              => 'required',
            'phone'             => ['required', 'regex:/(\+){0,1}(88){0,1}01(3|4|5|6|7|8|9)(\d){8}/', 'min:11', 'max:15'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address'           => 'required',
            'nid'               => ['required', 'unique:workers'],
            'description'       => 'nullable',
            'password'          => ['required'],
        ]);


        if ($request->hasfile('profile_image')) {
            $image = $request->file('profile_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/worker_images/' . $name_gen);
            $image = 'upload/worker_images/' . $name_gen;
        } else {
            $image = '';
        }
        if ($request->hasfile('nid_photo')) {
            $nidimage = $request->file('nid_photo');
            $name_gen = hexdec(uniqid()) . '.' . $nidimage->getClientOriginalExtension();
            Image::make($nidimage)->resize(300, 300)->save('upload/worker_images/nid_photo/' . $name_gen);
            $nidimage = 'upload/worker_images/nid_photo/' . $name_gen;
        } else {
            $nidimage = '';
        }


        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }
        if ($request->password == $request->confirm_password) {
            $password = $request->password;
        } else {
            Session::flash('warning', 'Password Do Not Match!');
            return redirect()->back();
        }

        WorkerSignupRequest::create([
            'name' => $request->name,
            'username' => $slug,
            'email' => $request->email,
            'password' => $password,
            'manufacture_part' => $request->selectePart,
            'profile_image' =>  $image,
            'phone' => $request->phone,
            'address' => $request->address,
            'nid' => $request->nid,
            'nid_photo' =>  $nidimage,
            'description' => $request->description,
            'status' => 1
        ]);
        Session::flash('success', 'Registration Request Successfully! Waiting For Admin Approved!');
        return redirect()->back();
    }




    /*
    |-----------------------------------------------------------------------------
    | LOGIN (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::guard('worker')->attempt($request->only('email', 'password'))) {
            if (Auth::guard('worker')->user()->role == "7" || Auth::guard('worker')->user()->role == "1") {
                if (Auth::guard('worker')->user()->is_approved == 1) {
                    return redirect()->route('worker.dashboard')->with('success', 'Worker Login Successfully.');
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
    }

    public function workerLogout(Request $request)
    {

        Auth::guard('worker')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Worker Logout Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('worker.login_form')->with($notification);
    }



    /*
    |-----------------------------------------------------------------------------
    | DASHBOARD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $id = Auth::guard('worker')->user()->id;
        $workerBalance = WorkerBalance::where('worker_id', $id)->first();
        $allOrders = Manufacture::where('user_id', $id)->count();
        $complatedOrder = Manufacture::where('user_id', $id)->where('is_complete', 1)->count();
        $pendingOrder = Manufacture::where('user_id', $id)->where('is_complete', 0)->count();
        return view('worker.index', compact('workerBalance', 'complatedOrder', 'pendingOrder','allOrders'));
    }


    /*
    |-----------------------------------------------------------------------------
    | ARTISAN CLEAR CACHE (METHOD)
    |-----------------------------------------------------------------------------
    */
    function clearCache()
    {
        Artisan::call('optimize:clear');
        Session::flash('success', 'Cache cleared successfully.');
        return redirect()->back();
    }


    /*
    |-----------------------------------------------------------------------------
    | WORKER PROFILE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function Profile()
    {
        $id = Auth::guard('worker')->user()->id;
        $workerData = User::find($id);

        // dd($dealerData);
        return view('worker.worker_profile_view', compact('workerData'));
    }


    /*
    |-----------------------------------------------------------------------------
    | WORKER EDIT PROFILE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function editProfile()
    {

        $id = Auth::guard('worker')->user()->id;
        $editData = User::find($id);
        return view('worker.worker_profile_edit', compact('editData'));
    }

    /*
    |-----------------------------------------------------------------------------
    | WORKER STORE PROFILE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function storeProfile(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'                  => 'required',
        ]);
        $id = Auth::guard('worker')->user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->hasfile('profile_image')) {

            if (file_exists($data->profile_image)) {
                unlink($data->profile_image);
            }

            $image = $request->profile_image;
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/worker_images/' . $name_gen);
            $image = 'upload/worker_images/' . $name_gen;
        } else {
            $image = $data->profile_image;
        }
        $data->profile_image = $image;
        $data->save();

        Session::flash('success', 'Worker Profile Updated Successfully');

        return redirect()->route('worker.profile');
    }


    /*
    |-----------------------------------------------------------------------------
    | WORKER CHANGE PASSWORD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function changePassword()
    {

        return view('worker.worker_change_password');
    }



    /*
    |-----------------------------------------------------------------------------
    | WORKER UPDATE PASSWORD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function updatePassword(Request $request)
    {

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::guard('worker')->user()->password;

        // dd($hashedPassword);
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $id = Auth::guard('worker')->user()->id;
            $worker = User::find($id);
            $worker->password = bcrypt($request->newpassword);
            $worker->save();

            Session::flash('success', 'Password Updated Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'Old password is not match');
            return redirect()->back();
        }
    }



    /*
    |-----------------------------------------------------------------------------
    | WORKER VIEW ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function viewOrder()
    {
        $id = Auth::guard('worker')->user()->id;
        $data['orders'] = Manufacture::where('user_id', $id)->where('is_confirm', 1)->latest()->get();
        // dd( $data['orders']);
        return view('worker.order.index', $data);
    }
    public function DateWiseSearch(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);
        $id = Auth::guard('worker')->user()->id;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $orders = Manufacture::query();

        if ($start_date || $end_date) {
            if ($start_date && $end_date) {
                $orders->where('user_id', $id)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            }
            elseif ($start_date) {
                $orders->where('user_id', $id)->where('created_at', '>=', $start_date . ' 00:00:00');
            } elseif ($end_date) {
                $orders->where('user_id', $id)->where('created_at', '<=', $end_date . ' 23:59:59');
            }
        }

        $orders = $orders->get();

        return view('worker.order.index', compact('orders'));
    }
    public function pendingDateWiseSearch(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);
        $id = Auth::guard('worker')->user()->id;
        $pendingOrders = Manufacture::query();
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        if ($start_date || $end_date) {
            if ($start_date && $end_date) {
                $pendingOrders->where('user_id', $id)->where('is_complete', 0)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            } elseif ($start_date) {
                $pendingOrders->where('user_id', $id)->where('is_complete', 0)->where('created_at', '>=', $start_date . ' 00:00:00');
            } elseif ($end_date) {
                $pendingOrders->where('user_id', $id)->where('is_complete', 0)->where('created_at', '<=', $end_date . ' 23:59:59');
            }
        }

        $pendingOrders = $pendingOrders->get();


        return view('worker.order.pending_order', compact('pendingOrders'));
    }
    public function confirmDateWiseSearch(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);

        $id = Auth::guard('worker')->user()->id;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $confirmedOrders  = Manufacture::query();

        if ($start_date || $end_date) {
            if ($start_date && $end_date) {
                $confirmedOrders->where('is_complete', 1)->where('user_id', $id)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            } elseif ($start_date) {
                $confirmedOrders->where('is_complete', 1)->where('user_id', $id)->where('created_at', '>=', $start_date . ' 00:00:00');
            } elseif ($end_date) {
                $confirmedOrders->where('is_complete', 1)->where('user_id', $id)->where('created_at', '<=', $end_date . ' 23:59:59');
            }
        }

        $confirmedOrders = $confirmedOrders->get();
        return view('worker.order.confirmed_order', compact('confirmedOrders'));
    }

    public function pendingOrder()
    {
        $id = Auth::guard('worker')->user()->id;
        $data['pendingOrders'] = Manufacture::where('user_id', $id)->where('is_confirm', 1)->where('is_complete', 0)->latest()->get();
        return view('worker.order.pending_order', $data);
    }
    public function confirmedOrder()
    {
        $id = Auth::guard('worker')->user()->id;
        $data['confirmedOrders'] = Manufacture::where('user_id', $id)->where('is_confirm', 1)->where('is_complete', 1)->latest()->get();
        return view('worker.order.confirmed_order', $data);
    }




    /*
    |-----------------------------------------------------------------------------
    | WORKER PRINT ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function printOrder($id)
    {
        $Workerid = Auth::guard('worker')->user()->id;
        $order = Manufacture::where('user_id', $Workerid)->where('id', $id)->first();
        return view('worker.order.printOrder', compact('order'));
    }


    /*
    |-----------------------------------------------------------------------------
    | WORKER VIEW Payment (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function viewPayment()
    {
        $id = Auth::guard('worker')->user()->id;

        $data['balances'] = ManufactureLedger::where('worker_id', $id)->latest()->get();
        return view('worker.payment.index', $data);
    }
    
    
    
     /*
    |-----------------------------------------------------------------------------
    | PRINT ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function orderPrint($id)
    {
        $data['order'] = Manufacture::find($id);
        return view('worker.order.printOrder', $data);
    }
}