<?php

namespace App\Http\Controllers\API\Dealer;

use App\Models\User;
use App\Models\Brand;
use App\Models\Staff;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DealerRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Dealer\PosResource;
use App\Http\Resources\Category\CategoryCustomResource;
use App\Models\DealerRequestConfirm;

class DealerApiController extends Controller
{
    public function dealerPos()
    {
        $products = Product::where('is_dealer', 1)->where('vendor_id', 0)->where('status', 1)->latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
        $brands = Brand::where('status', 1)->latest()->get();
        $staffs = Staff::latest()->get();
        $customers = User::where('role', 3)->where('status', 1)->latest()->get();

        // return view('dealer.template.pos.index', compact('products', 'categories', 'brands', 'customers', 'staffs'));
        // return response()->json([
        //     'products' => $products,
        //     'categories' => $categories,
        //     'brands' => $brands,
        //     'staffs' => $staffs,
        //     'customers' => $customers,
        // ]);
        return response()->json([
            'products' => PosResource::collection($products),
        ]);
    }

    public function dealerCategoryList()
    {
        $categories = Category::where('status', 1)->latest()->get();
        return response()->json([
            'category' => CategoryCustomResource::collection($categories),
        ]);
    }

    public function dealerCategoryWisePos($cat_id)
    {
        $products = Product::where('category_id', $cat_id)->where('is_dealer', 1)->where('vendor_id', 0)->where('status', 1)->latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
        return response()->json([
            'products' => PosResource::collection($products),
        ]);
    }

    public function dealerDashboard()
    {
        //$dealer = Dealer::where('user_id', Auth::guard('dealer-api')->user()->id)->first();
        //$all_requests = DealerRequest::where('user_id', Auth::guard('dealer-api')->user()->id)->latest()->get();

        $user = Auth::id();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated!!!!!!!'], 401);
        }

        $all_requests = DealerRequest::where('user_id', $user)->latest()->get();
        $all_requests_count = DealerRequest::where('user_id', $user)->count();
        $confirm_requests_count = DealerRequestConfirm::where('user_id', $user)->count();

        $userCount = DB::table('users')
            ->select(DB::raw('count(*) as total_users'))
            ->where('status', 1)
            ->where('role', 3)
            ->first();

        $productCount = DB::table('products')
            ->select(DB::raw('count(*) as total_products'))
            ->where('status', 1)
            ->where('approved', 1)
            ->first();

        $categoryCount = DB::table('categories')
            ->select(DB::raw('count(*) as total_categories'))
            ->where('status', 1)
            ->first();

        $brandCount = DB::table('brands')
            ->select(DB::raw('count(*) as total_brands'))
            ->where('status', 1)
            ->first();

        $orderCount = DB::table('orders')
            ->select(DB::raw('count(*) as total_orders, sum(grand_total) as total_sell'))
            ->first();

        $lowStockCount = DB::table('product_stocks as s')
            ->leftjoin('products as p', 's.product_id', '=', 'p.id')
            ->select(DB::raw('count(s.id) as total_low_stocks'))
            ->where('s.qty', '<=', 5)
            ->first();

        // dd($lowStockCount);
        return response()->json([
            'user_count' => $userCount,
            'product_count' => $productCount,
            'category_count' => $categoryCount,
            'brand_count' => $brandCount,
            'order_count' => $orderCount,
            'low_stock_count' => $lowStockCount,
            'all_requests' => $all_requests,
            'all_requests_count' => $all_requests_count,
            'confirm_requests_count' => $confirm_requests_count,
        ]);
    }

    // public function dealerDashboard()
    // {
    //     $user = Auth::guard('dealer-api')->user();

    //     if ($user) {
    //         $dealer = Dealer::where('user_id', $user->id)->first();

    //         if ($dealer) {
    //             // Dealer and user authenticated, continue with the logic
    //             dd($dealer);
    //         } else {
    //             // Handle the case when the Dealer record is not found
    //             return response()->json(['message' => 'Dealer record not found.'], 404);
    //         }
    //     } else {
    //         // Handle the case when the user is not authenticated
    //         return response()->json(['message' => 'User not authenticated.'], 401);
    //     }
    // }

    public function dealerProfile()
    {
        $id = Auth::user()->id;
        $dealerData = User::find($id);

        return response()->json([
            'profile' => $dealerData,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'phone'   => 'required',
            'address' => 'required'
        ]);
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/dealer_images'), $filename);
            $data['profile_image'] = 'upload/dealer_images/' . $filename;
        }
        $data->save();

        return response()->json([
            'profile' => $data,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;

        // dd($hashedPassword);
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $id = Auth::user()->id;
            $dealer = User::find($id);
            $dealer->password = bcrypt($request->newpassword);
            $dealer->save();

            return response()->json([
                'message' => "Password Updated Successfully",
            ]);
        } else {
            return response()->json([
                'message' => "Old password is not match!",
            ]);
        }
    }
}
