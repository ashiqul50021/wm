<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Manufacture;
use App\Models\ManufactureLedger;
use App\Models\User;
use App\Models\Worker;
use App\Models\WorkerBalance;
use App\Models\WorkerSignupRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Image;


class WorkerController extends Controller
{
    /*
    |-----------------------------------------------------------------------------
    | INDEX (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function index()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('48', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['workers'] = Worker::latest()->get();
            return view('backend.worker.index', $data);
        }
        else{
            Session::flash('error', 'You are not able to access the page');
            return back();
        }
    }


    /*
    |-----------------------------------------------------------------------------
    | CREATE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function create()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('49', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            return view('backend.worker.create');
        }
        else{
            Session::flash('error', 'You are not able to access the page');
            return back();
        }
    }


    /*
    |-----------------------------------------------------------------------------
    | STORE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'              => 'required',
            'phone'             => ['required', 'regex:/(\+){0,1}(88){0,1}01(3|4|5|6|7|8|9)(\d){8}/', 'min:11', 'max:15'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address'           => 'required',
            'nid'               => ['required', 'unique:workers'],
            'description'       => 'nullable',
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/worker_images/' . $name_gen);
            $image = 'upload/worker_images/' . $name_gen;
        } else {
            $image = '';
        }


        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        $role = 7;
        $user = User::create([
            'name'          => $request->name,
            'username'      => $slug,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'profile_image' => $image,
            'password'      => Hash::make($request->password),
            'status'        => $request->status ? 1 : 0,
            'is_approved'   => 0,
            'created_by'    => Auth::guard('admin')->user()->id,
            'role'          => $role,
        ]);

        Worker::insert([
            'name'              => $request->name,
            'user_id'           => $user->id,
            'description'       => $request->description,
            'nid'               => $request->nid,
            'manufacture_part'  => $request->manufacture_part,
            'status'            => $request->status ? 1 : 0,
            'created_by'        => Auth::guard('admin')->user()->id,
            'created_at'        => Carbon::now(),
        ]);

        Session::flash('success', 'Worker Inserted Successfully');
        return redirect()->route('worker.index');
    }


    /*
    |-----------------------------------------------------------------------------
    | SHOW (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function show($id)
    {
        $worker = Worker::findOrFail($id);
        $workerOrder = Manufacture::where('user_id', $worker->user_id)->where('is_complete', 1)->get();
        $workerOrderPending = Manufacture::where('user_id', $worker->user_id)->where('is_complete', 0)->get();


        return view('backend.worker.show', compact('worker', 'workerOrder', 'workerOrderPending'));
    }

    /*
    |-----------------------------------------------------------------------------
    | EDIT (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function edit($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('50', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['worker'] = Worker::findOrFail($id);
            return view('backend.worker.edit', $data);
        }
        else{
            Session::flash('error', 'You are not able to access the page');
            return back();
        }
    }

    /*
    |-----------------------------------------------------------------------------
    | UPDATE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name'              => 'required',
            'address'           => 'required',
            'nid'               => ['required'],
            'description'       => 'nullable',
            // 'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $worker = Worker::find($id);
        $user = User::find($worker->user_id);
        if ($request->phone == $user->phone) {
            $phone = $user->phone;
        } else {
            $worker_phone = User::where('phone', $request->phone)->first();
            if (!$worker_phone) {
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
            $worker_email = User::where('email', $request->email)->first();
            if (!$worker_email) {
                $email = $request->email;
            } else {
                $notification = array(
                    'message' => 'The email has already been taken.',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
        }

        if ($request->hasfile('image')) {

            if (file_exists($user->profile_image)) {
                unlink($user->profile_image);
            }

            $image = $request->image;
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/worker_images/' . $name_gen);
            $image = 'upload/worker_images/' . $name_gen;
        } else {
            $image = $user->profile_image;
        }
        // dd($image);
        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }
        $user->update([
            'name'          => $request->name,
            'username'      => $slug,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'address'       => $request->address,
            'profile_image' => $image,
            'status'        => $request->status ? 1 : 0,
            'is_approved'   => 0,
        ]);
        $user->worker()->update([
            'name'              => $request->name,
            'user_id'           => $user->id,
            'description'       => $request->description,
            'manufacture_part'  => $request->manufacture_part,
            'nid'               => $request->nid,
            'status'            => $request->status ? 1 : 0,
            'created_by'        => Auth::guard('admin')->user()->id,
            'created_at'        => Carbon::now(),
        ]);

        Session::flash('success', 'Worker Updated Successfully');
        return redirect()->route('worker.index');
    }

    /*
    |-----------------------------------------------------------------------------
    | DELETE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('51', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $worker = Worker::findOrFail($id);
            $user = User::where('id', $worker->user_id)->first();
            if (file_exists($user->profile_image)) {
                unlink($user->profile_image);
            }
            $worker->delete();
            $user->delete();
            $notification = array(
                'message' => 'Worker Deleted Successfully.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        else{
            Session::flash('error', 'You are not able to access the page');
            return back();
        }
    }

    /*
    |-----------------------------------------------------------------------------
    | APPROVED METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function approved($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {

            // dd($products);
            $user = User::find($id);
            $user->is_approved = 1;
            $user->save();

            Session::flash('success', 'Worker Approved Successfully.');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no Permission to Approved the worker');
            return back();
        }
    }



    /*
    |-----------------------------------------------------------------------------
    | ACTIVE METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function active($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $worker = Worker::find($id);
            $worker->status = 1;
            $worker->save();

            Session::flash('success', 'Worker Active Successfully.');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no permission to active the worker');
            return back();
        }
    }

    /*
    |-----------------------------------------------------------------------------
    | INACTIVE METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function inactive($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('2', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $worker = Worker::find($id);
            $worker->status = 0;
            $worker->save();

            Session::flash('warning', 'Worker Inactive Successfully.');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no permission to inactive the worker');
            return back();
        }
    }



    /*
    |-----------------------------------------------------------------------------
    | WORKER BALANCED METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function workerBalance()
    {
        $data['workerBalances'] = WorkerBalance::with('user')->latest()->get();
        // dd($data['workerBalances']);
        return view('backend.worker.warkerBalance', $data);
    }
    public function workerInactive()
    {
        $data['workerBalances'] = WorkerBalance::with('user')->where('status', 0)->latest()->get();
        // dd($data['workerBalances']);
        return view('backend.worker.inactive', $data);
    }

    public function workerChangeStatus ($id)
    {
        $status = WorkerBalance::find($id);
        if ($status->status == 1)
        {
            $status->status = 0;
        }
        elseif ($status->status == 0)
        {
            $status->status = 1;
        }
        $status->save();
        Session::flash('success', 'Change Status Successfully.');
        return redirect()->back();
    }

    /*
    |-----------------------------------------------------------------------------
    | WORKER PAYMENT METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function workerPayment($id)
    {
        $data = [];
        $data['collects'] = User::latest()->get();
        $data['workerBalance'] = WorkerBalance::find($id);
        return view('backend.worker.workerPayment', $data);
    }



    /*
    |-----------------------------------------------------------------------------
    | WORKER PAYMENT UPDATE METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function workerPaymentUpdate(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'invoice_no' => 'unique:manufacture_ledgers'
        ]);
        $workerBalance = WorkerBalance::find($id);
        $workerId = $workerBalance->worker_id;
        $workerBalance->update([
            'total_balance' => $request->remainingAmount
        ]);




        $prefix = 'INV'; // You can set a prefix for your invoice numbers
        $datePart = now()->format('Ymd'); // Add date information to the invoice number
        $uniqueId = DB::table('manufacture_ledgers')->count() + 1; // Get a unique identifier (incremental)

        // Generate the invoice number by combining prefix, date, and unique identifier
        $invoiceNumber = "{$prefix}-{$datePart}-{$uniqueId}";

        ManufactureLedger::create([
            'worker_id' => $workerId,
            'invoice_no' => $invoiceNumber,
            'debit' => 0,
            'credit' => $request->paidAmount,
            'total' => $request->remainingAmount,
            'collected_by' => Auth::guard('admin')->user()->id,
            'status'=> $request->status,
        ]);

        Session::flash('success', 'Payment done Successfully!');
        return redirect()->back();
    }

    /*
    |-----------------------------------------------------------------------------
    | UPDATE PASSWORD METHOD (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password'           => 'required',
            'password_confirmation'      => 'required|same:password',
        ]);
        $worker = User::find($id);
        $hashedPassword = $request->password_confirmation;
        //  dd($hashedPassword);
        if ($request->password === $hashedPassword) {
            $worker->password = bcrypt($request->password);
            $worker->save();

            Session::flash('success', 'Password Updated Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'password is not match');
            return redirect()->back();
        }
    }


    /*
    |-----------------------------------------------------------------------------
    | WORKER REGISTER REQUEST (METHOD)
    |-----------------------------------------------------------------------------
    */

    public function workerRegistrationRequest()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['registerRequest'] = WorkerSignupRequest::get();
            return view('backend.worker.workerRegisterRequest', $data);
        }
        else{
            Session::flash('error', 'You are not able to access the page');
            return back();
        }
    }



    /*
    |-----------------------------------------------------------------------------
    | WORKER REGISTER REQUEST SHOW (METHOD)
    |-----------------------------------------------------------------------------
    */

    public function workerRegistrationRequestShow($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {

            // dd($products);
            $data['workerRequest'] = WorkerSignupRequest::find($id);
            return view('backend.worker.workerRegisterRequestShow', $data);
        }
        else{
            Session::flash('error', 'You are not able to access the page');
            return back();
        }
    }
    /*
    |-----------------------------------------------------------------------------
    | WORKER REGISTER REQUEST ACCEPT (METHOD)
    |-----------------------------------------------------------------------------
    */

    public function workerRegistrationRequestAccept($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('520', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $workerRequest = WorkerSignupRequest::find($id);

            $role = 7;
            $user = User::create([
                'name'          => $workerRequest->name,
                'username'      => $workerRequest->username,
                'phone'         => $workerRequest->phone,
                'email'         => $workerRequest->email,
                'address'       => $workerRequest->address,
                'profile_image' => $workerRequest->profile_image,
                'password'      => Hash::make($workerRequest->password),
                'status'        => $workerRequest->status ? 1 : 0,
                'is_approved'   => 0,
                'created_by'    => Auth::guard('admin')->user()->id,
                'role'          => $role,
            ]);

            Worker::insert([
                'name'              => $workerRequest->name,
                'user_id'           => $user->id,
                'description'       => $workerRequest->description,
                'nid'               => $workerRequest->nid,
                'nid_photo'         => $workerRequest->nid_photo,
                'manufacture_part'  => $workerRequest->manufacture_part,
                'status'            => $workerRequest->status ? 1 : 0,
                'created_by'        => Auth::guard('admin')->user()->id,
                'created_at'        => Carbon::now(),
            ]);


            $workerRequest->delete();

            Session::flash('success', 'Worker Inserted Successfully');
            return redirect()->route('worker.index');
        }
    }


    /*
    |-----------------------------------------------------------------------------
    | WORKER REGISTER REQUEST DELETE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function workerRegistrationRequestDelete($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('5201', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $workerRequest = WorkerSignupRequest::find($id);
            if (file_exists($workerRequest->profile_image)) {
                unlink($workerRequest->profile_image);
            }
            if (file_exists($workerRequest->nid_photo)) {
                unlink($workerRequest->nid_photo);
            }
            $workerRequest->delete();
            Session::flash('success', 'Worker Deleted Successfully');
            return redirect()->back();
        }
        else{
            Session::flash('error', 'You have no permission to Delete');
            return back();
        }
    }
}