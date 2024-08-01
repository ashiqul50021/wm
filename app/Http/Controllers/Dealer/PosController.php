<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\AccountHead;
use App\Models\AccountLedger;
use App\Models\DealerRequest;
use App\Models\DealerRequestProduct;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Staff;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where('vendor_id', 0)->orWhere('vendor_id', null)->where('is_dealer', 1)->where('status', 1)->latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $staffs = Staff::latest()->get();
        $customers = User::where('role', 3)->where('status', 1)->latest()->get();
        return view('dealer.template.pos.index', compact('products', 'categories', 'brands', 'customers', 'staffs'));
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

    public function filter(Request $request)
    {
        // dd($request->all());
        $products = Product::where('is_dealer', 1)->where('status', 1);
        $value = $request->value;
        $products = $products
            ->where('name_en', 'like', '%' . $value . '%')
            ->orWhere('name_bn', 'like', '%' . $value . '%')
            ->orWhere('product_code', 'like', '%' . $value . '%')
            ->orWhere('variant_name', 'like', '%' . $value . '%')
            ->orWhere('model_number', 'like', '%' . $value . '%');

        // if (isset($_GET['category_id'])) {
        //     $products = $products->where('category_id', $_GET['category_id']);
        // }
        $products = $products->get();
        return json_encode($products);
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
        $product_ids = $request->product_id;
        if (!$product_ids || count($product_ids) <= 0) {
            return response()->json([
                'message' => "Add Atleast One Product!",
                'status' => 0
            ]);
        }
        $invoicePrefix = 'WMD-0001';
        $randomNumber = mt_rand(1000, 9999);

        $invoiceNumber = $invoicePrefix . $randomNumber;
        $dealer = DealerRequest::create([
            'user_id'           => $request->dealer_id,
            'total_amount'      => $request->grand_total,
            'delivery_status'   => 'Pending',
            'note'              => $request->comment,
            'invoice_no'    => $invoiceNumber,
        ]);

        $productId = $request->product_id;
        $qty = $request->qty;
        $price = $request->unit_price;


        foreach ($productId as $i => $id) {
            $item = [
                'dealer_request_id' => $dealer->id,
                'product_id' => $id,
                'qty' => $qty[$i],
                'price' => $price[$i]
            ];



            DealerRequestProduct::create($item);
        }

        // $notification = array(
        //     'message' => 'Your Request has been placed successfully.',
        //     'alert-type' => 'success'
        // );
        // return redirect()->route('dealer.all_request.index')->with($notification);
        return response()->json([
            'message' => "Dealer Order Place Successfully!",
            'data' => $dealer,
            'status' => 1
        ]);
        // return redirect()->route('dealer.print.invoice.download', compact('order'))->with($notification);
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
}
