<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DealerRequestDueProduct;
use App\Models\Manufacture;
use App\Models\ManufactureLedger;
use App\Models\ManufacturePrice;
use App\Models\ManufactureProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\Worker;
use App\Models\WorkerBalance;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use Session;


class ManufactureController extends Controller
{
    /*
    |-----------------------------------------------------------------------------
    | INDEX (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function index()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('25', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['orders'] = Manufacture::latest()->get();
            $data['users'] = User::latest()->get();
            // $data['collected'] =  ManufactureLedger::latest()->get();
            return view('backend.manufacture.index', $data);
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    // public function dateAndWorkerWiseSearch(Request $request)
    // {
    //     $this->validate($request, [
    //         'start_date' => 'required|date_format:Y-m-d',
    //         'end_date' => 'required|date_format:Y-m-d',
    //         'worker' => 'nullable|integer', // Adjust the validation rules based on your needs
    //     ]);
    //     $start_date = $request->input('start_date');
    //     $end_date = $request->input('end_date');
    //     $worker_id = $request->input('worker');

    //     $orders = Manufacture::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
    //     if ($worker_id) {
    //         $orders->where('user_id', $worker_id);
    //     }

    //     $orders = $orders->get();
    //     return view('backend.manufacture.index', compact('orders'));
    // }
    public function dateAndWorkerWiseSearch(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'worker' => 'nullable|integer',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $worker_id = $request->input('worker');

        $orders = Manufacture::query();

        if ($start_date || $end_date || $worker_id) {
            if ($start_date && $end_date) {
                $orders->whereBetween('updated_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            } else if ($start_date && $end_date && $worker_id) {
                $orders->whereBetween('updated_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                       ->where('user_id', $worker_id);
            } elseif ($start_date) {
                $orders->where('updated_at', '>=', $start_date . ' 00:00:00');
            } elseif ($end_date) {
                $orders->where('updated_at', '<=', $end_date . ' 23:59:59');
            }

            if ($worker_id) {
                $orders->where('user_id', $worker_id);
            }
        }

        $orders = $orders->get();
        return view('backend.manufacture.index', compact('orders'));
    }
    public function confirmedDateSearch(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'worker' => 'nullable|integer',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $worker_id = $request->input('worker');

        $confirmedOrders = Manufacture::query();

        if ($start_date || $end_date || $worker_id) {
            if ($start_date && $end_date) {
                $confirmedOrders->where('is_complete', 1)->whereBetween('updated_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            } else if ($start_date && $end_date && $worker_id) {
                $confirmedOrders->where('is_complete', 1)->whereBetween('updated_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                       ->where('user_id', $worker_id);
            } elseif ($start_date) {
                $confirmedOrders->where('is_complete', 1)->where('updated_at', '>=', $start_date . ' 00:00:00');
            } elseif ($end_date) {
                $confirmedOrders->where('is_complete', 1)->where('updated_at', '<=', $end_date . ' 23:59:59');
            }

            if ($worker_id) {
                $confirmedOrders->where('is_complete', 1)->where('user_id', $worker_id);
            }
        }

        $confirmedOrders = $confirmedOrders->get();

        return view('backend.manufacture.confirmed_order', compact('confirmedOrders'));
    }
    public function pendingDateSearch(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'worker' => 'nullable|integer',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $worker_id = $request->input('worker');

        $pendingOrders = Manufacture::query();

        if ($start_date || $end_date || $worker_id) {
            if ($start_date && $end_date) {
                $pendingOrders->where('is_complete', 0)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            } else if ($start_date && $end_date && $worker_id) {
                $pendingOrders->where('is_complete', 0)->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                       ->where('user_id', $worker_id);
            } elseif ($start_date) {
                $pendingOrders->where('is_complete', 0)->where('created_at', '>=', $start_date . ' 00:00:00');
            } elseif ($end_date) {
                $pendingOrders->where('is_complete', 0)->where('created_at', '<=', $end_date . ' 23:59:59');
            }

            if ($worker_id) {
                $pendingOrders->where('is_complete', 0)->where('user_id', $worker_id);
            }
        }

        $pendingOrders = $pendingOrders->get();
        return view('backend.manufacture.pending_order', compact('pendingOrders'));
    }




    /*
    |-----------------------------------------------------------------------------
    | CREATE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function create()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('24', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $searchQuery = request('search');
            $data['products'] = Product::where('is_varient', 1)->where('vendor_id', 0)->where(function ($query) use ($searchQuery) {
                $query->where('name_en', 'like', '%' . $searchQuery . '%')
                    ->orWhere('name_bn', 'like', '%' . $searchQuery . '%');
            })->latest()->with('manufactureProduct')->paginate(10);
            $data['workers'] = User::where('role', 7)->latest()->get();

            return view('backend.manufacture.create', $data);
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    /*
    |-----------------------------------------------------------------------------
    | GET PRODUCT ID FOR ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function GetProductId($id)
    {
        $productId = Product::select('id', 'name_en', 'stock_qty')->find($id);
        return json_decode($productId);
    }
    /*
    |-----------------------------------------------------------------------------
    | GET PRODUCT FOR ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function GetProductOrder($id)
    {
        $products = Product::find($id);
        return response()->json([
            'message' => 'Get product success!',
            'data' => $products
        ]);
    }
    /*
    |-----------------------------------------------------------------------------
    | GET WORKER MANUFACTURE FOR ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function GetWorkerManufacture(Request $request)
    {
        $worker = Worker::select('user_id', 'name')->where('manufacture_part', $request->menufacturePart)->get();
        return response()->json([
            'message' => 'Get manufacture success!',
            'data' => $worker
        ]);
    }



    /*
    |-----------------------------------------------------------------------------
    | SEARCH PRODUCT OF MANUFACTURE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function manufactureSearchProduct(Request $request)
    {
        $searchQuery = $request->search;
        $data['products'] = Product::where('is_varient', 1)->where('vendor_id', 0)->where(function ($query) use ($searchQuery) {
            $query->where('name_en', 'like', '%' . $searchQuery . '%')
                ->orWhere('name_bn', 'like', '%' . $searchQuery . '%');
        })->latest()->with('manufactureProduct')->get();
        return response()->json([
            'message' => "data get successfully!",
            'data' => $data
        ]);
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
            'user_id' => 'required',
            'product_id' => 'required',
            'manufacture_quantity' => 'required',
            'manufacture_part' => 'required',
            'manufacture_price' => 'required',

        ]);
        do {
            $manufactureCode = rand(10000, 99999);
        } while (Manufacture::where('manufacture_code', $manufactureCode)->exists());
        Manufacture::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'order_by' => Auth::guard('admin')->user()->id,
            'manufacture_quantity' => $request->manufacture_quantity,
            'manufacture_part' => $request->manufacture_part,
            'manufacture_code' => $manufactureCode,
            'manufacture_price' => $request->manufacture_price,
            'total_price' => $request->total_price,
            'is_confirm' => $request->is_confirm ?? 0,
            'dealer_name' => $request->dealer_name ?? null,
            'is_complete' => 0,
            'message' => $request->note ?? $request->message,
            'customer_name' => $request->customer_name ?? 'N/A',
            'is_dealer_manufacture' => $request->is_dealer_manufacture ?? '0', //from dealer request confirm product.
            'dealer_confirm_id' => $request->dealer_confirm_id ?? 'N/A' // from dealer request confirm producut
        ]);

        if($request->due_manufacture_id){
            $due_manufacture = DealerRequestDueProduct::find($request->due_manufacture_id);
            $due_manufacture->delete();
            FacadesSession::flash('success', 'Order Created Successfully');
            return redirect()->route('admin.dealer.order.due');
        }else{
            FacadesSession::flash('success', 'Order Created Successfully');
            return redirect()->back();
        }
        // ManufactureProduct::create([
        //     'product_id' => $request->product_id,
        //     'body_part_stock' => 0,
        //     'finishing_part_stock' => 0
        // ]);

    }

    public function pendingOrder()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('25', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['pendingOrders'] = Manufacture::where('is_complete', 0)->latest()->get();
            return view('backend.manufacture.pending_order', $data);
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }
    public function confirmedOrder()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('25', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['confirmedOrders'] = Manufacture::where('is_complete', 1)->latest()->get();
            return view('backend.manufacture.confirmed_order', $data);
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    public function completedOrder()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('26', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data = [];
            $data['completeOrders'] = Manufacture::where('is_complete', 1)->latest()->get();
            return view('backend.manufacture.completed_order', $data);
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    /*
    |-----------------------------------------------------------------------------
    | POST AND UPDATE MANUFACTURE ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function postManufactureByid(Request $request, $id)
    {
        $findmanufacture = Manufacture::find($id);
        do {
            $manufactureCode = rand(10000, 99999);
        } while (Manufacture::where('manufacture_code', $manufactureCode)->exists());
        Manufacture::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'manufacture_quantity' => $request->manufacture_quantity,
            'manufacture_part' => $request->manufacture_part,
            'manufacture_code' => $manufactureCode,
            'manufacture_price' => $request->manufacture_price,
            'total_price' => $request->total_price,
            'is_confirm' => $request->is_confirm,
            'dealer_name' => $request->dealer_name ?? null,
            'is_complete' => 0,
            'message' => $request->message
        ]);
        $findmanufacture->update([
            'is_body' => 1

        ]);
        Session::flash('success', 'Order Created Successfully');
        return redirect()->back();
    }


    /*
    |-----------------------------------------------------------------------------
    | EDIT (METHOD)
    |-----------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $data['manufacture'] = Manufacture::find($id);
        $data['products'] = Product::where('is_varient', 1)->latest()->get();
        $data['workers'] = User::where('role', 7)->latest()->get();
        return view('backend.manufacture.edit', $data);
    }


    /*
    |-----------------------------------------------------------------------------
    | UPDATE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
    }



    /*
    |-----------------------------------------------------------------------------
    | MANUFACTURE STOCK (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function ManufactureStock()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('28', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $data['manufactureStocks'] = ManufactureProduct::with('product')->get();
            return view('backend.manufacture.manufactureStock', $data);
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }


    /*
    |-----------------------------------------------------------------------------
    | MANUFACTURE STOCK DELETE(METHOD)
    |-----------------------------------------------------------------------------
    */
    public function ManufactureStockDelete($id)
    {
        $manufactureStocks = ManufactureProduct::find($id);
        $manufactureStocks->delete();
        Session::flash('success', 'Data Delete Successfully');
        return redirect()->back();
    }





    public function ManufacturePaymentInfo()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('30', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $manufactureLedger = ManufactureLedger::latest()->get();
            return view('backend.manufacture.manufacturePaymentinfo', compact('manufactureLedger'));
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    public function ManufacturePaymentExpense()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('30', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $manufactureLedger = ManufactureLedger::where('credit', '>', 0)->latest()->get();
            return view('backend.manufacture.manufacturePaymentexpense', compact('manufactureLedger'));
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }


    public function deletePaymentInfo($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('30', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $manufactureLedger = ManufactureLedger::find($id);
            $manufactureLedger->delete();
            Session::flash('success', 'Payment Info Delete Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }

    public function deleteExpense($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('31', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $manufactureLedger = ManufactureLedger::find($id);
            $manufactureLedger->delete();
            Session::flash('success', 'Expense Delete Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }


    public function PrintPaymentInfo($id)
    {
        $data['manufactureLedger'] = ManufactureLedger::find($id);
        return view('backend.manufacture.printPaymentInfo', $data);
    }
    public function PrintPaymentInfoExpense($id)
    {
        $data['manufactureLedger'] = ManufactureLedger::find($id);
        return view('backend.manufacture.printPaymentInfo', $data);
    }


    /*
    |-----------------------------------------------------------------------------
    | DISCARD ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */

    public function discardOrder($id)
    {
        $manufacture = Manufacture::find($id);
        $manufacture->update([
            'is_confirm' => 0
        ]);
        Session::flash('success', 'Discard Order Successfully');
        return redirect()->back();
    }

    /*
    |-----------------------------------------------------------------------------
    | CONFIRM ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function confirmOrder(Request $request, $id)
    {
        $manufacture = Manufacture::find($id);
        $value = $request->value;
        $manufacture->update([
            'is_confirm' => $value
        ]);
        // Session::flash('success', 'Confirm Order Successfully');
        // return redirect()->back();
        return response()->json([
            'message' => 'Order Change Sucessfully!',
            'data' => $manufacture
        ]);
    }


    /*
    |-----------------------------------------------------------------------------
    | COMPLETE ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function completeOrder($id)
    {
        $manufacture = Manufacture::find($id);
        $manufacture->update([
            'is_complete' => 1
        ]);
        Session::flash('success', 'Order Completed Successfully');
        return redirect()->back();
    }


    /*
    |-----------------------------------------------------------------------------
    | INCOMPLETE ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function incompleteOrder($id)
    {
        $manufacture = Manufacture::find($id);
        $manufacture->update([
            'is_complete' => 0
        ]);
        Session::flash('success', 'Order Incompleted Successfully');
        return redirect()->back();
    }


    /*
    |-----------------------------------------------------------------------------
    | DELETE (METHOD)
    |-----------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('26', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $orders = Manufacture::find($id);
            $orders->delete();
            Session::flash('success', 'Order Delete Successfully');
            return redirect()->back();
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }


    /*
    |-----------------------------------------------------------------------------
    | PRINT ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function orderPrint($id)
    {
        $data['order'] = Manufacture::find($id);
        return view('backend.manufacture.printOrder', $data);
    }


    /*
    |-----------------------------------------------------------------------------
    | ORDER PAYMENT (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function orderPayment()
    {
        return view('backend.manufacture.orderPay');
    }


    /*
    |-----------------------------------------------------------------------------
    | GET ORDER (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function getOrder($code)
    {
        $order = Manufacture::where('manufacture_code', $code)->with('product', 'user')->first();
        if ($order == null) {
            return response()->json([
                'message' => "Ordes Doesn't Match!",
                'data' => null
            ]);
        }
        return response()->json([
            'message' => "Order get Successfully",
            'data' => $order
        ]);
    }






    function generateInvoiceNumber()
    {
        $prefix = 'INV'; // You can set a prefix for your invoice numbers
        $datePart = now()->format('Ymd'); // Add date information to the invoice number
        $uniqueId = DB::table('manufacture_ledgers')->count() + 1; // Get a unique identifier (incremental)

        // Generate the invoice number by combining prefix, date, and unique identifier
        $invoiceNumber = "{$prefix}-{$datePart}-{$uniqueId}";

        return $invoiceNumber;
    }

    /*
    |-----------------------------------------------------------------------------
    | ORDER PAYMENT STORE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function paymentStore(Request $request)
    {
        // dd($request->all());

        $order = Manufacture::where('id', $request->manuId)->first();
        if ($order->is_complete == 1) {
            Session::flash('warning', 'Already Collect Order!');
            return redirect()->back();
        } else if($order->is_complete == 0 || $order->is_complete === null){
            $request->validate([
                'invoice_no' => 'unique:manufacture_ledgers'
            ]);
            $manufacture = ManufactureLedger::where('worker_id', $request->worker_id)->latest()->first();

            if ($manufacture) {
                $total = $manufacture->total + $request->debit;
            } else {
                $total = $request->debit;
            }




            $prefix = 'INV'; // You can set a prefix for your invoice numbers
            $datePart = now()->format('Ymd'); // Add date information to the invoice number
            $uniqueId = DB::table('manufacture_ledgers')->count() + 1; // Get a unique identifier (incremental)

            // Generate the invoice number by combining prefix, date, and unique identifier
            $invoiceNumber = "{$prefix}-{$datePart}-{$uniqueId}";


            ManufactureLedger::create([
                'collected_by' =>$request->collected_by,
                'worker_id' => $request->worker_id,
                'invoice_no' => $invoiceNumber,
                'debit' => $request->debit,
                'credit' => 0,
                'total' => $total,
                // 'due_amount' => $request->due_amount
            ]);

            WorkerBalance::updateOrInsert(
                [
                    'worker_id' => $request->worker_id
                ],
                [
                    'total_balance' => $total
                ]
            );

            if ($request->manupart == 'body-part') {
                $bodypart = ManufactureProduct::where('product_id', $request->product_id)->first();
                // $bodypartqty = ManufactureProduct::sum('body_part_stock');
                if ($bodypart) {
                    $bodypartqty = $bodypart->body_part_stock + $request->manupartqty;
                } else {
                    $bodypartqty =  $request->manupartqty;
                }

                ManufactureProduct::updateOrInsert(
                    [
                        'product_id' => $request->product_id
                    ],
                    [
                        'body_part_stock' => $bodypartqty,

                    ]
                );
            } else {
                $product = Product::where('id', $request->product_id)->first();
                $finishingpart = ManufactureProduct::where('product_id', $request->product_id)->first();
                if ($finishingpart) {
                    $finishingpartqty = $finishingpart->finishing_part_stock + $request->manupartqty;
                } else {
                    $finishingpartqty = $request->manupartqty;
                }
                ManufactureProduct::updateOrInsert(
                    [
                        'product_id' => $request->product_id
                    ],
                    [
                        'finishing_part_stock' => $finishingpartqty,

                    ]
                );
                $previousStock = $product->stock_qty;
                $currentStock = $previousStock + $request->manupartqty;
                $product->update([
                    'stock_qty' => $currentStock
                ]);
            }
            $order->update([
                'is_complete' => 1,
                'collected_by' =>Auth::guard('admin')->user()->id ,
            ]);
            Session::flash('success', 'Order Collect Successfully');
            return redirect()->back();
        }
    }


    //     public function paymentStore(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $order = Manufacture::where('id', $request->manuId)->first();
    //         if (!$order) {
    //             Session::flash('error', 'Order not found!');
    //             return redirect()->back();
    //         }

    //         if ($order->is_complete == 1) {
    //             Session::flash('warning', 'Already Collected Order!');
    //             return redirect()->back();
    //         }

    //         $request->validate([
    //             'invoice_no' => 'unique:manufacture_ledgers'
    //         ]);

    //         $manufacture = ManufactureLedger::where('worker_id', $request->worker_id)->latest()->first();

    //         if ($manufacture) {
    //             $total = $manufacture->total + $request->debit;
    //         } else {
    //             $total = $request->debit;
    //         }

    //         // Your existing logic...

    //         // Ensure to update the order status or perform any other necessary actions
    //         $order->update([
    //             'is_complete' => 1
    //         ]);

    //         DB::commit();

    //         Session::flash('success', 'Order collected successfully!');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         // Log or handle the exception as needed
    //         Session::flash('error', 'Failed to complete the order. Please try again.');
    //         return redirect()->back();
    //     }
    // }



    /*
    |-----------------------------------------------------------------------------
    | ORDER PAYMENT List (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function paymentList()
    {
        $data['payments'] = ManufacturePrice::latest()->get();
        return view('backend.manufacture.orderPaylist', $data);
    }
    /*
    |-----------------------------------------------------------------------------
    | ORDER PAYMENT EDIT (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function paymentEdit($id)
    {
        $data['payment'] = ManufacturePrice::find($id);
        return view('backend.manufacture.orderPayEdit', $data);
    }

    /*
    |-----------------------------------------------------------------------------
    | ORDER PAYMENT UPDATE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function paymentUpdate(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([]);

        $payment = ManufacturePrice::find($id);
        $payment->update([
            'manufacture_id' => $request->manufacture_id,
            'total_price' => $request->total_amount,
            'pay_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount
        ]);
        Session::flash('success', 'Order Payment Updated Successfully');
        return redirect()->back();
    }


    /*
    |-----------------------------------------------------------------------------
    | BODY PART ORDER INFO (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function bodyPartOrderInfo()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('29', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            // $bodyorders = Manufacture::latest()->get();
           $bodyorders = Manufacture::where('manufacture_part', 'body-part')->where('is_confirm', 1)->where('is_body', 0)->latest('updated_at')->get();
            // dd($bodyorders);
            return view('backend.manufacture.bodyPartInfo', compact('bodyorders'));
        } else {
            Session::flash('error', 'You have no permission to Access the page');
            return back();
        }
    }




    public function getManufactureByid($id)
    {
        $manufactureOrder = Manufacture::with('product')->find($id);
        $worker = Worker::where('manufacture_part', 'finishing-part')->get();
        $responseData = [
            'manufactureOrder' => $manufactureOrder,
            'workers' => $worker
        ];
        return response()->json($responseData);
    }



    /*
    |-----------------------------------------------------------------------------
    | ORDER PAYMENT DELETE (METHOD)
    |-----------------------------------------------------------------------------
    */
    public function destroyOrder($id)
    {
        $payments = ManufacturePrice::find($id);
        $payments->delete();
        Session::flash('success', 'Order Payment Delete Successfully');
        return redirect()->back();
    }
    
    

    // get Dealer manufacture

    public function getDealerManufacture(Request $request){
        $products = Product::select('id','menu_facture_image','product_thumbnail','body_rate','name_en')->find($request->product_id);
        $quantity = $request->quantity;
        $workers = User::where('role',7)->whereHas('worker',function($q){
            $q->where('manufacture_part','body-part');
        })->get();
        return response()->json([
            'products' => $products,
            'quantity' => $quantity,
            'workers' => $workers
        ]);
    }
}