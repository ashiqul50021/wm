<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{



    public function productReviewStore(Request $request)
    {
        $request->validate([]);
        // dd($request->all());
        $productReview = ProductReview::create([
            'product_id' => $request->product_id,
            'user_name' => $request->customerName,
            'comment' => $request->comment,
            'start_rating' => $request->rating,
            'status' => 0
        ]);

        return response()->json([
            'message' => 'Review Submitted Successfully!',
            'data' => $productReview,
        ]);
    }
}
