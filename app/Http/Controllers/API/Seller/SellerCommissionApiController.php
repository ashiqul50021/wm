<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\SellerCommissionApiResource;
use App\Models\SellerCommission;
use Illuminate\Http\Request;

class SellerCommissionApiController extends Controller
{
   public function commissionView(){

    $commission = SellerCommission::latest()->get();

    if(!$commission){
        return response()->json([

            'message' => 'Not Found',
        ],404);
    }
    return response()->json([
        'Commissions' => SellerCommissionApiResource::collection($commission),

    ],200);
   }
}
