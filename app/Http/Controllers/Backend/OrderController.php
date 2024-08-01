<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AccountLedger;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Address;
use App\Models\DealerRequest;
use App\Models\DealerRequestConfirm;
use App\Models\DealerRequestDueProduct;
use App\Models\DealerRequestProduct;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Shipping;
use App\Models\Product;
use App\Models\ProductStock;
// use Session;
use PDF;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date;
        $delivery_status = null;
        $payment_status = null;

        if ($request->delivery_status != null && $request->payment_status != null && $date != null) {

            $orders = Order::where('created_at', '>=', date('Y-m-d', strtotime(explode(" - ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" - ", $date)[1])))->where('delivery_status', $request->delivery_status)->where('payment_status', $request->payment_status);

            $delivery_status = $request->delivery_status;
            $payment_status = $request->payment_status;
        } else if ($request->delivery_status == null && $request->payment_status == null && $date == null) {
            $orders = Order::orderBy('id', 'desc');
        } else {
            if ($request->delivery_status == null) {
                if ($request->payment_status != null && $date != null) {
                    $orders = Order::where('created_at', '>=', date('Y-m-d', strtotime(explode(" - ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" - ", $date)[1])))->where('payment_status', $request->payment_status);
                    $payment_status = $request->payment_status;
                } else if ($request->payment_status == null && $date != null) {
                    $orders = Order::where('created_at', '>=', date('Y-m-d', strtotime(explode(" - ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" - ", $date)[1])));
                } else {
                    $orders = Order::where('payment_status', $request->payment_status);
                    $payment_status = $request->payment_status;
                }
            } else if ($request->payment_status == null) {
                if ($request->delivery_status != null && $date != null) {
                    $orders = Order::where('created_at', '>=', date('Y-m-d', strtotime(explode(" - ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" - ", $date)[1])))->where('delivery_status', $request->delivery_status);
                    $delivery_status = $request->delivery_status;
                } else if ($request->delivery_status == null && $date != null) {
                    $orders = Order::where('created_at', '>=', date('Y-m-d', strtotime(explode(" - ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" - ", $date)[1])));
                } else {
                    $orders = Order::where('delivery_status', $request->delivery_status);
                    $delivery_status = $request->delivery_status;
                }
            } else if ($request->date == null) {
                if ($request->delivery_status != null && $request->payment_status != null) {
                    $orders = Order::where('delivery_status', $request->delivery_status)->where('payment_status', $request->payment_status);
                    $delivery_status = $request->delivery_status;
                    $payment_status = $request->payment_status;
                } else if ($request->delivery_status == null && $request->payment_status != null) {
                    $orders = Order::where('payment_status', $request->payment_status);
                    $payment_status = $request->payment_status;
                } else {
                    $orders = Order::where('delivery_status', $request->delivery_status);
                    $delivery_status = $request->delivery_status;
                }
            }
        }

        //dd($request);

        $orders = $orders->where('type', '!=', 4)->paginate(15);
        return view('backend.sales.all_orders.index', compact('orders', 'delivery_status', 'date', 'payment_status'));
    }

    public function dealerOrderIndex()
    {

        $orders = DealerRequestConfirm::where('delivery_status', '!=', 'delivered')->latest()->get();

        // dd($orders);
        return view('backend.sales.all_orders.dealer_index', compact('orders'));
    }

    public function dealerOrderDelivered()
    {
        // $orders = Order::where('type', 4)->get();
        $orders = DealerRequestConfirm::where('delivery_status', 'delivered')->latest()->get();
        // dd($orders);
        return view('backend.sales.all_orders.dealer_delivered', compact('orders'));
    }



    public function dealerOrderDue()
    {
        $dueOrder = DealerRequestDueProduct::latest()->get();
        return view('backend.sales.all_orders.dealer_due', compact('dueOrder'));
    }


    public function dealerOrderdueDelete($id)
    {
        $dueProduct = DealerRequestDueProduct::find($id);
        $dueProduct->delete();
        Session::flash('success', 'Due Product Deleted Suceesfully!');
        return redirect()->back();
    }



    public function dealerOrderManufacture($id)
    {
        $dueManufacture = DealerRequestDueProduct::find($id);
        return view('backend.sales.all_orders.dealer_due_manufacture', compact('dueManufacture'));
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

    public function dealer_order(Request $request)
    {


        // dd($request->all());
        $request->validate([]);
        $dealerRequestOld = DealerRequest::find($request->dealer_request_id);
        $oldRequest = $dealerRequestOld->invoice_no;
        if ($request->has('product_id')) {
            $dealerConfirm = DealerRequestConfirm::create([
                'invoice_no'        => $oldRequest,
                'user_id'           => $request->dealer_id,
                'total_amount'      => $request->total_amount,
                'confirm_amount'    => $request->total_selected_amount,
                'pending_amount'    => (int)$request->total_amount - (int)$request->total_selected_amount ?? '0',
                'note'              => $request->comments,
                'delivery_status'   => 'pending'
            ]);

            foreach ($request->product_id as $key => $productid) {
                $dealerConfirmProduct = $dealerConfirm->requestConfirmProduct()->create([
                    'product_id' => $productid,
                    'request_qty' => $request->requested_qty[$productid],
                    'confirm_qty' => $request->confirm_qty[$productid],
                    'due_qty' => $request->due_quantity[$productid],
                    'unit_price' => $request->unit_price[$productid],
                    'total_price' => ($request->confirm_qty[$productid]) * ($request->unit_price[$productid]),
                ]);

                if ($request->due_quantity[$productid] != 0) {
                    $dealerRequestDue = DealerRequestDueProduct::create([
                        'user_id' => $request->dealer_id,
                        'product_id' => $productid,
                        'qty' => $request->due_quantity[$productid],
                        'unit_price' => $request->unit_price[$productid]
                    ]);
                }
                $dealerRequest = DealerRequest::find($request->dealer_request_id);
                $selectedProduct = $dealerRequest->dealer_request_products()->where('product_id', $productid)->first();
                $remainingProduct = $dealerRequest->dealer_request_products()->where('product_id', '!=', $productid)->count();
                $remainingProductValue = $dealerRequest->dealer_request_products()
                    ->where('product_id', '!=', $productid)
                    ->select(DB::raw('SUM(qty * price) as total'))
                    ->pluck('total')
                    ->first();
                if ($selectedProduct) {
                    $selectedProduct->delete();
                    $dealerRequest->update([
                        'total_amount' => $remainingProductValue
                    ]);
                    if ($remainingProduct == 0) {
                        $dealerRequest->delete();
                    }
                }
            }





            $notification = array(
                'message' => 'Your order has been placed successfully.',
                'alert-type' => 'success'
            );
            // $pdf = PDF::loadView('backend.invoices.dealer_invoice_new', compact('dealerConfirm'))->setPaper('a4');
            // return $pdf->download('invoice.pdf');
            // return view('backend.invoices.dealer_invoice_new', compact('dealerConfirm'))->with($notification);
            return redirect()->route('admin.dealer.order.confirm')->with($notification);
        } else {
            Session::flash('warning', 'Please select at least one product!');
            return redirect()->back();
        }
    }


    public function dealerReorderStore(Request $request)
    { {

            // dd($request->all());
            $request->validate([]);

            if ($request->has('product_id')) {
                $dealerConfirm = DealerRequestConfirm::create([
                    'user_id'           => $request->dealer_id,
                    'total_amount'      => $request->total_selected_amount,
                    'note'              => $request->comments,
                    'delivery_status'   => 'pending'
                ]);

                foreach ($request->product_id as $key => $productid) {
                    $dealerConfirmProduct = $dealerConfirm->requestConfirmProduct()->create([
                        'product_id' => $productid,
                        // 'request_qty' => $request->requested_qty[$productid],
                        'confirm_qty' => $request->confirm_qty[$key],
                        // 'due_qty' => $request->due_quantity[$productid],
                        'unit_price' => $request->unit_price[$key],
                        'total_price' => $request->product_total_price[$key],
                    ]);
                }

                $notification = array(
                    'message' => 'Your order has been placed successfully.',
                    'alert-type' => 'success'
                );
                // $pdf = PDF::loadView('backend.invoices.dealer_invoice_new', compact('dealerConfirm'))->setPaper('a4');
                // return $pdf->download('invoice.pdf');
                return view('backend.invoices.dealer_invoice_new', compact('dealerConfirm'))->with($notification);
            } else {
                Session::flash('warning', 'Please Full fill Stock product!');
                return redirect()->back();
            }
        }
    }

    public function dealer_menuimg_print($id, $dealer)
    {
        $dealer_request_product = DealerRequestProduct::findOrFail($id);
        $product_stock = ProductStock::findOrFail($dealer_request_product->product_stock_id);
        $product = Product::where('id', $dealer_request_product->product_id)->first();
        $dealer = User::findOrFail($dealer);
        return view('backend.sales.dealer_manufac_print', compact('dealer_request_product', 'product', 'dealer', 'product_stock'));
    }
    public function dealer_order_menuimg_print($id, $dealer)
    {
        $dealer_request_product = OrderDetail::findOrFail($id);
        $product_stock = ProductStock::findOrFail($dealer_request_product->product_stock_id);
        $product = Product::where('id', $dealer_request_product->product_id)->first();
        $dealer = User::findOrFail($dealer);
        return view('backend.sales.dealer_manufac_print', compact('dealer_request_product', 'product', 'dealer', 'product_stock'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $shippings = Shipping::where('status', 1)->get();

        return view('backend.sales.all_orders.show', compact('order', 'shippings'));
    }

    public function updateDeliveryStatus(Request $request)
    {
        $orderId = $request->input('orderId');
        $statusType = $request->input('statusType');

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delivery_status = $statusType;

        // Save the changes
        $order->update();

        return response()->json(['success' => 'Status updated successfully']);
        // Session::flash('success', 'Admin Orders Information Updated Successfully');
        // return redirect()->back();

    }
    public function dealerShow($id)
    {
        // $order = Order::findOrFail($id);
        $order = DealerRequestConfirm::findOrFail($id);
        return view('backend.sales.all_orders.dealer_show', compact('order'));
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
        $this->validate($request, [
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

        Session::flash('success', 'Admin Orders Information Updated Successfully');
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
        $order = Order::findOrFail($id);
        $order->order_details()->delete();
        $order->delete();


        $notification = array(
            'message' => 'Order Deleted Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function dealerOrderdestroy($id)
    {
        $order = DealerRequestConfirm::findOrFail($id);
        $order->requestConfirmProduct()->delete();
        $order->delete();


        $notification = array(
            'message' => 'Order Deleted Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    /*================= Start update_payment_status Methoed ================*/
    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $order->payment_status = $request->status;
        $order->save();

        // dd($order);

        return response()->json(['success' => 'Payment status has been updated']);
    }

    /*================= Start update_delivery_status Methoed ================*/
    public function update_delivery_status(Request $request)
    {
        $order = DealerRequestConfirm::findOrFail($request->order_id);
        // dd($order);
        $order->delivery_status = $request->status;
        $order->save();

        return response()->json(['success' => 'Delivery status has been updated']);
    }



    /*================= Start admin_user_update Methoed ================*/
    public function admin_user_update(Request $request, $id)
    {
        $user = Order::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // dd($user);

        Session::flash('success', 'Customer Information Updated Successfully');
        return redirect()->back();
    }

    /* ============= Start getdivision Method ============== */
    public function getdivision($division_id)
    {
        $division = District::where('division_id', $division_id)->orderBy('district_name_en', 'ASC')->get();

        return json_encode($division);
    }
    /* ============= End getdivision Method ============== */

    /* ============= Start getupazilla Method ============== */
    public function getupazilla($district_id)
    {
        $upazilla = Upazilla::where('district_id', $district_id)->orderBy('name_en', 'ASC')->get();

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
    // public function invoice_download($id)
    // {
    //     $order = Order::findOrFail($id);
    //     //dd(app('url')->asset('upload/abc.png'));
    //     $pdf = PDF::loadView('backend.invoices.invoice', compact('order'))->setPaper('a4');
    //     return $pdf->download('invoice.pdf');
    // } // end method

    // newly added
    public function invoice_download($id)
    {
        $order = Order::with('order_details')->find($id);
        return view('backend.invoices.invoice', compact('order'));
    }
    public function orderPrints($id)
    {
        $order = Order::with('order_details')->find($id);
        return view('backend.invoices.print', compact('order'));
    }

    public function dealerInvoiceDownload($id)
    {
        // $order = Order::findOrFail($id);
        // //dd(app('url')->asset('upload/abc.png'));
        // $pdf = PDF::loadView('backend.invoices.dealer_invoice', compact('order'))->setPaper('a4');
        // return $pdf->download('invoice.pdf');
        $dealerConfirm = DealerRequestConfirm::find($id);
        $notification = array(
            'message' => 'Download Invoice!',
            'alert-type' => 'success'
        );

        return view('backend.invoices.dealer_invoice_new', compact('dealerConfirm'))->with($notification);
    } // end method


    public function dealerNewInvoiceDownload($id)
    {
        // $order = Order::findOrFail($id);
        // //dd(app('url')->asset('upload/abc.png'));
        // $pdf = PDF::loadView('backend.invoices.dealer_invoice', compact('order'))->setPaper('a4');
        // return $pdf->download('invoice.pdf');
        $dealerConfirm = DealerRequestConfirm::find($id);
        $notification = array(
            'message' => 'Download Invoice!',
            'alert-type' => 'success'
        );

        return view('backend.invoices.dealer_invoices_new', compact('dealerConfirm'))->with($notification);
    } // end method

    /* ============= End invoice_download Method ============== */
    public function invoice_print_download($id)
    {
        //dd($id);
        $order = Order::findOrFail($id);
        //dd(app('url')->asset('upload/abc.png'));
        // $pdf = PDF::loadView('backend.invoices.invoice',compact('order'))->setPaper('a4');
        // dd($pdf);
        return view('backend.invoices.invoice_print', compact('order'));
        // return $pdf->loadView('invoice.pdf');
    } // end method

}