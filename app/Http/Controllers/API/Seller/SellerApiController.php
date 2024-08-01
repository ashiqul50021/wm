<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SellerApiController extends Controller
{

    public function sellerDashboard()
    {

        $user = Auth::user()->id;
        // dd('user check',$user);
        $seller = Seller::where('user_id', $user)->first();
        $products = Product::where('seller_id', $user)->latest()->get();

        if (!$seller) {
            return response()->json([
                'status' => 'error',
                'message' => 'Seller not found or profile not created.',
            ], 404);
        }

        // dd($seller);

        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to Dashboard',
            'data' => $products,
        ], 200);
    }
}
