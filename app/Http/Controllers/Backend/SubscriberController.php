<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Session;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('87', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(15);
            return view('backend.subscribers.index', compact('subscribers'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subscriber = Subscriber::where('email', $request->email)->first();
        if($subscriber == null){
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->save();

            Session::flash('success','You have subscribed successfully.');
            return back();
        }
        else{
            $notification = array(
                'message' => 'You are  already a subscriber.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
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
        if (Auth::guard('admin')->user()->role == '1' || in_array('877', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            Subscriber::destroy($id);

            Session::flash('success','Subscriber has been deleted successfully.');
            return redirect()->route('subscribers.index');
        }
        else{
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }
}
