<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{

    public function AdminDashboard()
    {

        // $adminProducts = Product::where('vendor_id', null)->orWhere('vendor_id', 0)->latest()->get();
        // $vendor = Vendor::where('user_id', Auth::guard('admin')->user()->id)->first();

        // $userCount = DB::table('users')
        //     ->select(DB::raw('count(*) as total_users'))
        //     ->where('status', 1)
        //     ->where('role', 3)
        //     ->first();

        // if (Auth::guard('admin')->user()->role == '2') {
        //     $productCount = DB::table('products')
        //         ->select(DB::raw('count(*) as total_products'))
        //         ->where('vendor_id', Auth::guard('admin')->user()->id)
        //         ->where('status', 1)
        //         ->where('approved', 1)
        //         ->first();

        //     if ($vendor) {
        //         $productCount = DB::table('products')
        //             ->select(DB::raw('count(*) as total_products'))
        //             ->where('vendor_id', $vendor->id)
        //             ->where('status', 1)
        //             ->where('approved', 1)
        //             ->first();
        //     }
        // } else {
        //     $productCount = DB::table('products')
        //         ->select(DB::raw('count(*) as total_products'))
        //         ->where('status', 1)
        //         ->where('approved', 1)
        //         ->first();
        // }

        // $categoryCount = DB::table('categories')
        //     ->select(DB::raw('count(*) as total_categories'))
        //     ->where('status', 1)
        //     ->first();

        // $brandCount = DB::table('brands')
        //     ->select(DB::raw('count(*) as total_brands'))
        //     ->where('status', 1)
        //     ->first();

        // $vendorCount = DB::table('vendors')
        //     ->select(DB::raw('count(*) as total_vendors'))
        //     ->where('status', 1)
        //     ->first();

        // $orderCount = DB::table('orders')
        //     ->select(DB::raw('count(*) as total_orders, sum(grand_total) as total_sell'))
        //     ->first();

        // $lowStockCount = DB::table('product_stocks as s')
        //     ->leftjoin('products as p', 's.product_id', '=', 'p.id')
        //     ->select(DB::raw('count(s.id) as total_low_stocks'))
        //     ->where('p.vendor_id', Auth::guard('admin')->user()->id)
        //     ->where('s.qty', '<=', 5)
        //     ->first();

        // if ($vendor) {
        //     $lowStockCount = DB::table('product_stocks as s')
        //         ->leftjoin('products as p', 's.product_id', '=', 'p.id')
        //         ->select(DB::raw('count(s.id) as total_low_stocks'))
        //         ->where('p.vendor_id', $vendor->id)
        //         ->where('s.qty', '<=', 5)
        //         ->first();
        // }

        // $responseData = [
        //     'userCount' => $userCount->total_users,
        //     'productCount' => $productCount->total_products,
        //     'categoryCount' => $categoryCount->total_categories,
        //     'brandCount' => $brandCount->total_brands,
        //     'vendorCount' => $vendorCount->total_vendors,
        //     'orderCount' => [
        //         'total_orders' => $orderCount->total_orders,
        //         'total_sell' => $orderCount->total_sell,
        //     ],
        //     'lowStockCount' => $lowStockCount->total_low_stocks,
        //     'adminProducts' => $adminProducts,
        // ];

        // return response()->json($responseData, 200);
        // $Admin = Auth::user();
        // return response()->json([
        //     'message' => 'Welcome to Admin Dashboard',
        //     'admin' => $Admin,

        // ]);


    $Admin = Auth::user();
    return response()->json([
        'message' => 'Welcome to Admin Dashboard',
        'admin' =>$Admin,

    ]);
}


    public function slider()
    {
        $sliders = Slider::where('status', '1')->latest()->get();
        if ($sliders->isEmpty()) {
            return response()->json(['message' => 'No Slider found'], 200);
        }

        return response()->json([
            'data' => $sliders,
        ]);
        // return ProductResource::collection($products);
    }
    public function sellerProductApproved($id){

        $product = Product::find($id);
        $product->approved = 1;

        return response()->json([
            'message' => 'Product Approved Successfully',
        ]);
    }

    public function sellerApprove($id){
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->is_approved = '1';
        $user->save();

        return response()->json([
            'message' => 'Approved the seller Successfully',
            'data' => $user,
        ],200);
    }
}
