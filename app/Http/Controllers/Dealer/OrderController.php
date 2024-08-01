<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Address;
use App\Models\DealerRequest;
use App\Models\DealerRequestConfirm;
use App\Models\DealerRequestConfirmProduct;
use App\Models\DealerRequestProduct;
use App\Models\District;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Upazilla;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Session;
use PDF;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all_requests = DealerRequest::where('user_id', Auth::guard('dealer')->user()->id)->latest()->paginate(20);
        return view('dealer.template.sales.all_request', compact('all_requests'));
    }

    public function dealerOrderIndex(){
        $orders = DealerRequestConfirm::where('user_id', Auth::guard('dealer')->user()->id)->latest()->get();
        return view('dealer.template.sales.all_orders.dealer_index', compact('orders'));
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
        $dealer = DealerRequest::with('dealer_request_products')->findOrFail($id);

        return view('dealer.template.sales.all_request_show', compact('dealer'));
    }

    public function dealerShow($id)
    {
        $order = DealerRequestConfirm::findOrFail($id);
        return view('dealer.template.sales.all_orders.dealer_show', compact('order'));
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
        $this->validate($request,[
            'payment_method' => 'required',
        ]);
        $order = Order::findOrFail($id);

        $order->division_id = $request->division_id;
        $order->district_id = $request->district_id;
        $order->upazilla_id = $request->upazilla_id;
        $order->payment_method = $request->payment_method;

        $discount_total = ($order->sub_total - $request->discount);
        $total_ammount = ($discount_total + $request->shipping_charge);

        Order::where('id', $id)->update([
            'shipping_charge'   => $request->shipping_charge,
            'discount'          => $request->discount,
            'grand_total'       => $total_ammount,
        ]);
        $order->save();

        Session::flash('success','Admin Orders Information Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $dealer_request = DealerRequest::findOrFail($id);
        $dealer_request_product = DealerRequestProduct::where('request_status',1)->first();
        if(!$dealer_request_product){
            $dealer_request->delete();
            $notification = array(
                'message' => 'Order Request Deleted Successfully.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Your Order Request approved Can\'t be Deleted.',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
    }

    /*================= Start update_payment_status Methoed ================*/
    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $order->payment_status = $request->status;
        $order->save();

        // dd($order);

        return response()->json(['success'=> 'Payment status has been updated']);

    }

    /*================= Start update_delivery_status Methoed ================*/
    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_status = $request->status;
        $order->save();

        return response()->json(['success'=> 'Delivery status has been updated']);

    }



    /*================= Start admin_user_update Methoed ================*/
    public function admin_user_update(Request $request, $id)
    {
        $user = Order::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // dd($user);

        Session::flash('success','Customer Information Updated Successfully');
        return redirect()->back();
    }

    /* ============= Start getdivision Method ============== */
    public function getdivision($division_id){
        $division = District::where('division_id', $division_id)->orderBy('district_name_en','ASC')->get();

        return json_encode($division);
    }
    /* ============= End getdivision Method ============== */

    /* ============= Start getupazilla Method ============== */
    public function getupazilla($district_id){
        $upazilla = Upazilla::where('district_id', $district_id)->orderBy('name_en','ASC')->get();

        return json_encode($upazilla);
    }
    /* ============= End getupazilla Method ============== */

    /* ============= Start invoice_download Method ============== */
    // public function invoice_download($id){
    //     $order = Order::findOrFail($id);

    //     $pdf = PDF::loadView('backend.invoices.invoice',compact('order'))->setPaper('a4')->setOptions([
    //             'tempDir' => public_path(),
    //             'chroot' => public_path(),
    //     ]);
    //     return $pdf->download('invoice.pdf');
    // } // end method

    /* ============= Start invoice_download Method ============== */
    public function invoice_download($id){
        $order = Order::findOrFail($id);
        //dd(app('url')->asset('upload/abc.png'));
        $pdf = PDF::loadView('dealer.template.invoices.invoice',compact('order'))->setPaper('a4');
        return $pdf->download('invoice.pdf');
    } // end method

    public function dealerInvoiceDownload($id){

        $dealerConfirm = DealerRequestConfirm::find($id);
        $notification = array(
            'message' => 'Download Invoice!',
            'alert-type' => 'success'
        );

        return view('dealer.template.invoices.dealer_invoice_new', compact('dealerConfirm'))->with($notification);
    } // end method


    /* ============= End invoice_download Method ============== */
     public function invoice_print_download($id){
        //dd($id);
        $order = Order::findOrFail($id);
        //dd(app('url')->asset('upload/abc.png'));
        // $pdf = PDF::loadView('backend.invoices.invoice',compact('order'))->setPaper('a4');
        // dd($pdf);
        return view('dealer.template.invoices.invoice_print', compact('order'));
        // return $pdf->loadView('invoice.pdf');
    } // end method

}
