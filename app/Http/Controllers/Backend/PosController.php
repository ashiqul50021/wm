<?php

namespace App\Http\Controllers\Backend;

use PDF;
use Session;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Product;
use App\Models\Category;
use App\Models\PosOrder;
use App\Models\Attribute;
use App\Models\AccountHead;
use App\Models\OrderDetail;
use App\Models\AdminPosList;
use App\Models\PosOrderItem;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\AccountLedger;
use Illuminate\Support\Carbon;
use App\Models\CustomerDueCollect;
use App\Models\CustomerDuePayment;
use Illuminate\Support\Facades\DB;
use App\Models\AdminPosListProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('status', 1)->where('vendor_id', 0)->latest()->get();
        // dd($products);
        $staffs = Staff::latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $customers = User::where('role', 3)->where('status', 1)->latest()->get();
        //return $products;
        return view('backend.pos.index', compact('products', 'categories', 'brands', 'customers', 'staffs'));
    }



    public function getProduct($id)
    {
        $idarr = explode("_", $id);
        if (sizeof($idarr) > 1) {
            $product_stock = ProductStock::findOrFail($idarr[1]);
            $product = Product::findOrFail($idarr[0]);

            $product->varient = $product_stock->varient;
            $product->wholesell_price = $product_stock->wholesaleprice;
            $product->stock_qty = $product_stock->qty;
        } else {
            $product = Product::findOrFail($id);
        }

        return json_encode($product);
    }
    public function getCountProducts(Request $request)
    {
        $count = $request->input('count', 10);
        $query = Product::where('status', 1)->where('vendor_id', 0)->latest();

        if (!empty($count)) {
            $query->limit($count);
        }
        $Allproducts = $query->get();
        return response()->json($Allproducts);
    }


    public function getCustomer(Request $request)
    {
        $customerName = $request->input('customerName');

        if ($customerName) {
            $suggestionsName = User::where('role', 3)
                ->where('vendor_id', null)
                ->where('seller_id', null)
                ->where('name', 'LIKE', '%' . $customerName . '%')
                ->get();
            return response()->json($suggestionsName);
        }
    }

    public function getCustomerByPhone(Request $request)
    {
        $customerPhone = $request->input('customerPhone');

        if ($customerPhone) {
            $suggestionsNumber = User::where('role', 3)
                ->where('vendor_id', null)
                ->where('seller_id', null)
                ->where('phone', 'LIKE', '%' . $customerPhone . '%')->get();
            return response()->json($suggestionsNumber);
        }
    }


    public function addToList(Request $request)
    {
        $product = $request->addedProducts;
        $list = AdminPosList::where('user_id', Auth::guard('admin')->user()->id)->first();
        if ($list) {
            $existingProduct = AdminPosListProduct::where('product_id', $product['id'])
                ->with('product')
                ->where('user_id', Auth::guard('admin')->user()->id)
                ->first();

            if ($existingProduct) {
                // if($existingProduct->product->stock_qty < )
                // dd($existingProduct);
                $quantity = (int)$existingProduct->quantity;
                $discountType = $existingProduct->discount_type;
                $discount = $existingProduct->discount;
                $unitPrice = $existingProduct->unit_price;
                $totalPrice = $existingProduct->total_price;
                $newQuantity = $quantity + 1;

                if ($existingProduct->product->stock_qty < $newQuantity) {
                    return response()->json([
                        'data' => null,
                        'status' => 'false',
                        'message' => 'you have reached maximum of stock!'
                    ]);
                } else {
                    $newDisocuntAmount = 0;
                    $newTotalPrice = $unitPrice * $newQuantity;
                    if ($discountType == 'percentage') {
                        $newDisocuntAmount = $newTotalPrice * $discount / 100;
                    } else {
                        $newDisocuntAmount =  $discount;
                    }
                    // $newAfterDisocuntPrice = $newTotalPrice -  $newDisocuntAmount ?? 0;
                    $newAfterDiscountPrice = 0;
                    if ($newDisocuntAmount == 0) {
                        $newAfterDiscountPrice =  $newTotalPrice;
                    } else {
                        $newAfterDiscountPrice =  $newTotalPrice - $newDisocuntAmount;
                    }




                    // for list


                    // dd($newQuantity);
                    $existingProduct->update([
                        'quantity' => $newQuantity,
                        'discount_amount' =>  $newDisocuntAmount,
                        'total_price' => $newTotalPrice,
                        'after_discount_price' => $newAfterDiscountPrice,
                    ]);


                    $newsubtotal = 0;
                    $newTotalProducDiscount = 0;



                    foreach ($list->adminPosProduct as $product) {
                        $newsubtotal += $product->after_discount_price;
                    }
                    foreach ($list->adminPosProduct as $product) {
                        $newTotalProducDiscount += $product->discount_amount;
                    }

                    $newDiscount = $list->discount;
                    $overallDiscount = $newTotalProducDiscount + $newDiscount;              // Update the subtotal and total in the list
                    $list->update([
                        'sub_total' => $newsubtotal,
                        'total_product_discount' => $newTotalProducDiscount,
                        'discount' => $newDiscount,
                        'overall_discount' => $overallDiscount,
                        'total' => $newTotalProducDiscount
                    ]);
                }
            } else {
                $list->adminPosProduct()->create([
                    'product_id' => $product['id'],
                    'user_id' => Auth::guard('admin')->user()->id,
                    'product_image' => $product['product_thumbnail'],
                    'title' => $product['name_en'],
                    'quantity' => 1,
                    'discount' => 0,
                    'discount_type' => 'flat',
                    'discount_amount' => 0,
                    'unit_price' =>  $product['regular_price'] - $product['discount_price'],
                    'total_price' =>  $product['regular_price'] - $product['discount_price'],
                    'after_discount_price' =>  $product['regular_price'] - $product['discount_price']
                ]);
                $subTotal = $list->sub_total + $product['regular_price'] - $product['discount_price'];
                $list->update([
                    'sub_total' => $subTotal,
                    'total' => $subTotal
                ]);
            }
        } else {
            $total =  (float)$product['regular_price'] - (float)$product['discount_price'];
            // dd($total);
            $list = AdminPosList::create([
                'user_id' => Auth::guard('admin')->user()->id,
                'sub_total' => $total,
                'total_product_discount' => 0,
                'discount' => 0,
                'overall_discount' => 0,
                'note' => '',
                'total' => $total
            ]);
            $list->adminPosProduct()->create([
                'product_id' => $product['id'],
                'user_id' => Auth::guard('admin')->user()->id,
                'product_image' => $product['product_thumbnail'],
                'title' => $product['name_en'],
                'quantity' => 1,
                'discount' => 0,
                'discount_type' => 'flat',
                'discount_amount' => 0,
                'unit_price' =>  $total,
                'total_price' =>  $total,
                'after_discount_price' =>  $total
            ]);
        }

        $listproduct = AdminPosListProduct::with('product')
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->get();
        return response()->json([
            'data' => $listproduct,
            'status' => 'true',
            'message' => 'add to list success!'
        ]);
    }


    public function getPosProduct()
    {
        $posProducts = AdminPosListProduct::with('product')
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->get();
        return response()->json([
            'data' => $posProducts,
            'message' => 'get product successfully!'
        ]);
    }




    public function updateQuantity(Request $request, $id)
    {
        $list = AdminPosList::where('user_id', Auth::guard('admin')->user()->id)->first();
        $listProduct = AdminPosListProduct::where('product_id', $id)
            ->with('product')->where('user_id', Auth::guard('admin')->user()->id)
            ->first();
        $newquantity = $request->newQuantity;
        if ($listProduct->product->stock_qty < $newquantity) {

            return response()->json([
                'status' => "false",
                'message' => 'you have reached maximum of stock!',

                'data' => null

            ]);
        } else {
            $totalPrice = $listProduct->unit_price;
            $newTotalPrice = $totalPrice * $newquantity;
            $discountValue = $listProduct->discount;
            $discountType = $listProduct->discount_type;
            if ($discountType == 'percentage') {
                $newDisocuntAmount = $newTotalPrice * $discountValue / 100;
            } else {
                $newDisocuntAmount =  $discountValue;
            }

            $newAfterDiscountPrice = 0;
            if ($newDisocuntAmount == 0) {
                $newAfterDiscountPrice =  $newTotalPrice;
            } else {
                $newAfterDiscountPrice =  $newTotalPrice - $newDisocuntAmount;
            }
            $listProduct->update([
                'quantity' => $newquantity,
                'total_price' => $newTotalPrice,
                'discount_amount' => $newDisocuntAmount,
                'after_discount_price' => $newAfterDiscountPrice,
            ]);
            $posProducts = AdminPosListProduct::with('product')
                ->where('user_id', Auth::guard('admin')->user()->id)
                ->get();


            return response()->json([
                'status' => "true",
                'message' => 'Product quantity updated.',

                'data' => $posProducts,

            ]);
        }
    }


    public function updateDiscount(Request $request, $id)
    {
        $posProductList = AdminPosListProduct::where('product_id', $id)
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->first();
        $discountValue = $request->value;
        $discountType = $posProductList->discount_type;
        $unitPrice = (float)$posProductList->unit_price;
        $quantity = (int)$posProductList->quantity;
        $newDisocuntAmount = 0;
        $newTotalPrice = $unitPrice * $quantity;
        if ($discountType == 'percentage') {
            $newDisocuntAmount = $newTotalPrice * $discountValue / 100;
        } else {
            $newDisocuntAmount =  $discountValue;
        }

        $newAfterDiscountPrice = 0;
        if ($newDisocuntAmount == 0) {
            $newAfterDiscountPrice =  $newTotalPrice;
        } else {
            $newAfterDiscountPrice =  $newTotalPrice - $newDisocuntAmount;
        }

        $posProductList->update([
            'discount' => $discountValue,
            'discount_amount' => $newDisocuntAmount,
            'after_discount_price' => $newAfterDiscountPrice,
        ]);


        $posProducts = AdminPosListProduct::with('product')
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->get();


        return response()->json([
            'message' => 'Product quantity updated.',

            'data' => $posProducts,

        ]);
    }

    public function updateUnitPrice(Request $request, $id)
    {
        $posProductList = AdminPosListProduct::where('product_id', $id)
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->first();
        $unitPrice = (float)$request->unit_price;
        $discount_type = $posProductList->discount_type;
        $discount = (float)$posProductList->discount_amount;
        $totalPrice = $unitPrice * $posProductList->quantity;
        $totalAfterDiscount = $totalPrice;
        if ($discount_type == 'flat') {
            $totalAfterDiscount = $totalPrice - $discount;
        } else {
            $finalDiscount = $totalPrice * $discount / 100;
            $totalAfterDiscount = $totalPrice - $finalDiscount;
        }

        $totalPrice =  $unitPrice * $posProductList->quantity;
        $posProductList->update([
            'unit_price' => $unitPrice,
            'total_price'  => $totalPrice,
            'after_discount_price' => $totalAfterDiscount
        ]);


        $posProducts = AdminPosListProduct::with('product')
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->get();


        return response()->json([
            'message' => 'Product unit Price updated.',

            'data' => $posProducts,

        ]);
    }

    public function updateDiscountType(Request $request, $id)
    {
        $posProductList = AdminPosListProduct::where('product_id', $id)
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->first();
        $discountType = $request->value;
        $discountvalue = $posProductList->discount;
        $unitPrice = (float)$posProductList->unit_price;
        $quantity = (int)$posProductList->quantity;
        $newDisocuntAmount = 0;
        $newTotalPrice = $unitPrice * $quantity;
        if ($discountType == 'percentage') {
            $newDisocuntAmount = $newTotalPrice * $discountvalue / 100;
        } else {
            $newDisocuntAmount =  $discountvalue;
        }

        $newAfterDiscountPrice = 0;
        if ($newDisocuntAmount == 0) {
            $newAfterDiscountPrice =  $newTotalPrice;
        } else {
            $newAfterDiscountPrice =  $newTotalPrice - $newDisocuntAmount;
        }

        $posProductList->update([
            'discount_amount' => $newDisocuntAmount,
            'discount_type' => $discountType,
            'after_discount_price' => $newAfterDiscountPrice,
        ]);


        $posProducts = AdminPosListProduct::with('product')
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->get();


        return response()->json([
            'message' => 'Product quantity updated.',

            'data' => $posProducts,

        ]);
    }




    public function removeProduct($id)
    {
        $posProductList = AdminPosListProduct::where('product_id', $id)
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->first();
        $posProductList->delete();
        $productlist = AdminPosListProduct::with('product')
            ->where('user_id', Auth::guard('admin')->user()->id)
            ->get();
        return response()->json([
            'data' => $productlist,
            'message' => 'Item not found.',
        ]);
    }


    public function updateCalculate(Request $request)
    {
        $list = AdminPosList::where('user_id', Auth::guard('admin')->user()->id)->first();
        if ($list) {
            $discount = $request->discount;
            $overallDiscount = $request->overallDiscount;
            $totalProductDiscount = $request->totalProductDiscount;
            $totalProductSubtotal = $request->totalProductSubtotal;
            $paid = $request->paid;
            $total = $request->total;
            $mesage = $request->message;
            $due = $request->due;

            $list->update([
                'sub_total' => $totalProductSubtotal,
                'total_product_discount' => $totalProductDiscount,
                'discount' => $discount,
                'overall_discount' => $overallDiscount,
                'note' => $mesage,
                'total' => $total,
                'paid' => $paid,
                'due' => $due,
            ]);
        }
        return response()->json([
            'message' => 'Calculate success',
            'data' => $list
        ]);
    }


    public function filter()
    {
        $products = DB::table('products')
            ->where('status', 1)
            ->where('vendor_id', 0);
        //return json_encode($products);
        if (isset($_GET['search_term'])) {
            $products = $products->where('products.name_en', 'like', '%' . $_GET['search_term'] . '%')->orWhere('products.model_number', 'like', '%' . $_GET['search_term'] . '%')->orWhere('products.tags', 'like', '%' . $_GET['search_term'] . '%');
        }
        if (isset($_GET['category_id'])) {
            $products = $products->where('category_id', $_GET['category_id']);
        }
        $products = $products->get();
        return json_encode($products);
    }

    public function barcode_search_ajax($id)
    {
        $product_barcode = Product::where('product_code', $id)->first();
        if ($product_barcode != null) {
            $product_stock = ProductStock::with('product')->where('product_id', $product_barcode->id)->get();
            return json_encode($product_stock);
        } else {
            $product_barcode = ProductStock::where('stock_code', $id)->first();
            $product_stock_barcode = DB::table('products')
                ->join('product_stocks', 'products.id', '=', 'product_stocks.product_id')
                ->where('status', 1)
                ->where('products.id', $product_barcode->product_id)
                ->get();
            return json_encode($product_stock_barcode);
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
        // dd($request->all());
        if (
            Auth::guard('admin')->user()->role == '1' ||
            in_array('1000', json_decode(Auth::guard('admin')->user()->staff->role->permissions))
        ) {
            // dd($request->all());
            $phoneToFind = $request->customerPhoneFind;
            $nameToFind = $request->customerNameFind;
            $addressToFind = $request->customerAddressFind;

            // if ($request->customer_id == 0 && $request->subtotal != $request->paid_amount) {
            if ($request->customer_id == 0 && $phoneToFind == 0) {
                $notification = array(
                    'message' => 'Walking Customer Not allow Due amount.',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }

            $userid = $request->customer_id;
            // if (!$userid) {
            //     $user = User::create([
            //         'name' =>$nameToFind ?? 'Walking Customer',
            //         'status' => 1,
            //         'is_approved' => 1,
            //         'role' => 3,
            //         'vendor_id' => null,
            //         'phone' => $phoneToFind,
            //         'password' => bcrypt('12345678901'),
            //     ]);
            //     $userid = $user->id;
            // }
            if (!$userid) {
                $name = $nameToFind ?? null;
                $NewAddress = $addressToFind ?? null;

                $user = User::create([
                    'name' => $name,
                    'address' => $NewAddress,
                    'status' => 1,
                    'is_approved' => 1,
                    'role' => 3,
                    'vendor_id' => null,
                    'phone' => $phoneToFind,
                    'password' => bcrypt('12345678'),
                ]);

                if (!$name) {
                    $user->update(['name' => 'Walking Customer']);
                }

                $userid = $user->id;
            }


            $gust_user = User::where('role', 4)->first();
            $prefix = 'WM';
            $datePart = now()->format('Ymd');
            $uniqueId = DB::table('pos_orders')->count() + 1;

            $invoiceNumber = "{$prefix}-{$datePart}-{$uniqueId}";

            $overallDiscount = $request->discount + $request->totalDiscountAmount;

            $order = PosOrder::create([
                'user_id'                   => $userid,
                'seller_id'                 => 0,
                'invoice_no'                => $invoiceNumber,
                'sale_by'                   => $request->staff_id == '0' ? Auth::guard('admin')->user()->id : $request->staff_id,
                'total'                     => $request->grand_total,
                'subtotal'                  => $request->subtotal,
                'discount'                  => $request->totalDiscountAmount ?? '0',
                'additional_discount'       => $request->discount ?? '0',
                'overall_discount'          => $request->overallDiscount ?? '0',
                'paid'                      => $request->paid_amount,
                'due'                       => $request->due_amount ?? '0',
                'discription'               => $request->note ?? '',


            ]);

            $product_ids = $request->product_id;

            for ($i = 0; $i < count($product_ids); $i++) {
                $product = Product::find($product_ids[$i]);



                PosOrderItem::insert([
                    'pos_order_id' => $order->id,
                    'qty' => $request->product_qty[$i],
                    'product_image' => $product->product_thumbnail ?? 0,
                    'product_id' => $product->id ?? '',
                    'product_name' => $product->name_en ?? '',
                    'product_price' => $request->unit_price[$i],
                    'product_discount' => $request->discount_amount[$i],
                    'product_discount_type' => $request->discount_type[$i],
                    'product_total_price' => $request->totalPrice[$i],
                    'total_after_discount' => $request->total_after_discount[$i],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $product->update([
                    'stock_qty' => $product->stock_qty - $request->product_qty[$i]
                ]);
            }

            if ($request->due_amount > 0) {
                $customerduepayment = CustomerDuePayment::where('customer_id', $request->customer_id)->first();
                if ($customerduepayment) {

                    $previousDue = (float)$customerduepayment->total_due;
                    $currentDue = (float)$request->due_amount;
                    $totalDue =  $previousDue + $currentDue;

                    $customerduepayment->update([
                        'total_due' => $totalDue,
                    ]);
                    $customerduepayment->customerDueItem()->create([
                        'pos_order_id' => $order->id,
                        'created_at' => Carbon::now(),

                    ]);
                } else {

                    $customerdue = CustomerDuePayment::create([
                        'customer_id' => $request->customer_id,
                        'total_due' => $request->due_amount,
                        'created_at' => Carbon::now(),
                    ]);
                    $customerdue->customerDueItem()->create([
                        'pos_order_id' => $order->id,
                        'created_at' => Carbon::now(),

                    ]);
                }
            }


            $ledger_balance = get_account_balance() + $request->paid_amount;
            //Ledger Entry
            $ledger = AccountLedger::create([
                'account_head_id' => 1,
                'particulars' => "Pos Order Sell",
                'credit' =>  $request->paid_amount,
                'balance' => $ledger_balance,
                'type' => 2,
            ]);


            $adminlist = AdminPosList::where('user_id',Auth::guard('admin')->user()->id)->first();
            $adminlist->adminPosProduct()->delete();
            $adminlist->delete();

            $notification = array(
                'message' => 'Your order has been placed successfully.',
                'alert-type' => 'success'
            );

            session()->forget('list');
            return redirect()->route('pos.viewPosOrder', $order->id);
        } else {
            $notification = array(
                'message' => 'Not Allow To Place An Order',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }


    public function viewPosOrder($id)
    {
        $posOrder = PosOrder::with('posOrderItem')->find($id);
        $previousDue =  CustomerDuePayment::where('customer_id', $posOrder->user_id)->select('total_due')->first();
        return view('backend.invoices.posorder_invoice', compact('posOrder', 'previousDue'));
    }



    public function orderPrint($id)
    {
        $posOrder = PosOrder::with('posOrderItem')->find($id);
        return view('backend.invoices.posorder_invoice_print2', compact('posOrder'));
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
        //
    }
    /* ============== Customer Store Ajax ============ */
    public function customerInsert(Request $request)
    {
        // if($request->name == Null){
        //     return response()->json(['error'=> 'Customer Field Required']);
        // }

        $this->validate($request, [
            'name'              => 'required',
            'username'          => ['nullable', 'unique:users'],
            'phone'             => ['required', 'regex:/(\+){0,1}(88){0,1}01(3|4|5|6|7|8|9)(\d){8}/', 'min:11', 'max:15', 'unique:users'],
            'email'             => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'address'           => 'required',
            'profile_image'     => 'nullable',
        ]);

        $customer = new User();
        if ($request->hasfile('profile_image')) {
            $image = $request->file('profile_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/user/' . $name_gen);
            $save_url = 'upload/user/' . $name_gen;
        } else {
            $save_url = '';
        }
        $customer->profile_image = $save_url;

        $customer->name     = $request->name;
        $customer->username = $request->username;
        $customer->phone    = $request->phone;
        $customer->email    = $request->email;
        $customer->address  = $request->address;
        $customer->role     = 3;
        $customer->status   = 1;
        $customer->password = Hash::make("12345678");
        $customer->save();

        $customers = User::where('role', 3)->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => 'Customer Inserted Successfully',
            'customers' => $customers,
        ]);
    }
    public function barcode_ajax($id)
    {
        $product_barcode = Product::where('product_code', $id)->first();
        // dd($product_barcode);
        if ($product_barcode != null) {
            //dd($product_barcode);
            return json_encode($product_barcode);
        } else {
            $product_stock_barcode = ProductStock::where('stock_code', $id)->first();
            //dd($product_stock_barcode);
            return json_encode($product_stock_barcode);
        }
    }




    public function orderList()
    {
        $posOrder = PosOrder::latest()->paginate(20);

        return view('backend.sales.pos_order.index', compact('posOrder'));
    }

    public function searchByPosReport(Request $request)
    {
        $posOrder = PosOrder::when($request->has('date'), function ($query) use ($request) {
            $dateRange = explode(" - ", $request->input('date'));
            $startDate = Carbon::createFromFormat('d-m-Y', $dateRange[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d-m-Y', $dateRange[1])->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->get();

        return view('backend.sales.pos_order.index', compact('posOrder'));
    }


    public function orderShow($id)
    {
        $posorder = PosOrder::with('posOrderItem', 'saleby')->find($id);
        // dd($posorder);
        return view('backend.sales.pos_order.view', compact('posorder'));
    }


    public function orderDue()
    {
        $customerDue = CustomerDuePayment::where('vendor_id', null)->with('customer')->latest()->get();
        // dd($customerDue);
        return view('backend.sales.pos_order.customer_due', compact('customerDue'));
    }



    public function dueCollect($id)
    {
        $customerdue = CustomerDuePayment::find($id);
        return view('backend.sales.pos_order.customer_due_collect', compact('customerdue'));
    }


    public function dueCollectUpdate(Request $request, $id)
    {
        // dd($request->all());

        $customerDuePayment = CustomerDuePayment::find($id);
        $prefix = 'WMCA';
        $datePart = now()->format('Ymd');
        $uniqueId = DB::table('customer_due_collect')->count() + 1;

        $invoiceNumber = "{$prefix}-{$datePart}-{$uniqueId}";
        CustomerDueCollect::create([
            'invoice_id'  => $invoiceNumber,
            'customer_id'  => $request->customer_id,
            'collected_by' => Auth::guard('admin')->user()->id,
            'collect_amount' => $request->collectedAmount,
            'remaining_amount' => $request->remainingAmount,
        ]);
        if ($request->remainingAmount == '0') {
            $customerDuePayment->update([
                'total_due' => $request->remainingAmount
            ]);
            $customerDuePayment->delete();
        } else {
            $customerDuePayment->update([
                'total_due' => $request->remainingAmount
            ]);
        }

        $ledger_balance = get_account_balance() + $request->collectedAmount;
        //Ledger Entry
        $ledger = AccountLedger::create([
            'account_head_id' => 1,
            'particulars' => "Collect Customer Payment",
            'credit' => $request->collectedAmount,
            'balance' => $ledger_balance,
            'type' => 2,
        ]);

        $notification = array(
            'message' => 'Due Update succesfully!',
            'alert-type' => 'success!'
        );

        return redirect()->route('pos.orderDue')->with($notification);
    }




    public function getOrderForDue($id)
    {
        $order = PosOrder::find($id);
        return response()->json([
            'message' => "Order get successfully!",
            'data' => $order
        ]);
    }


    public function dueCollectInfo()
    {
        $dueCollectInfo = CustomerDueCollect::where('vendor_id', null)
            ->with('collectedBy')
            ->latest()
            ->get();
        return view('backend.sales.pos_order.customer_due_collect_info', compact('dueCollectInfo'));
    }


    public function dueCollectInfoPrint($id)
    {
        $dueCllectionInfo = CustomerDueCollect::find($id);
        return view('backend.invoices.customer_collect_payment', compact('dueCllectionInfo'));
    }

    public function dueCollectInfoDelete($id)
    {
        $dueCollectInfo = CustomerDueCollect::find($id);
        $dueCollectInfo->delete();
        $notification = array(
            'message' => 'Due Delete succesfully!',
            'alert-type' => 'success!'
        );
        return redirect()->back()->with($notification);
    }



    public function orderDelete($id)
    {
        $order = PosOrder::find($id);
        $order->posOrderItem()->delete();
        $order->delete();
        $notification = array(
            'message' => 'Order delete succesfully!',
            'alert-type' => 'success!'
        );
        return redirect()->back()->with($notification);
    }
}