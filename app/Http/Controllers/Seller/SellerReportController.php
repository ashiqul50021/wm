<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerReportController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::guard('seller')->user()->role;
        if ($role == "9") {
            $products = Product::where('status', 1)
                ->where('approved', 1)
                ->where('seller_id', Auth::guard('seller')->user()->id)
                ->orderBy('created_at', 'desc')->get();

            return view('seller.template.reports.index', compact('products'));
        }
    }

  
}
