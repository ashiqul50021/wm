<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerBrandApiController extends Controller
{
    public function BrandView()
    {
        $brands = Brand::latest()->get();
        if (!$brands) {
            return response()->json([
                'message' => 'Not Found',

            ], 404);
        }

        return response()->json([

            'Brands' => $brands,
        ]);
    }
}
