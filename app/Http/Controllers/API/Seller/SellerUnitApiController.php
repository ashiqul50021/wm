<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class SellerUnitApiController extends Controller
{
    public function unitView(){

        $unit = Unit::latest()->get();

        if(!$unit){
            return response()->json([
                'message' => 'Not Found',
            ],404);
        }

        return response()->json([
            'Unit' => $unit,
        ],200);
    }
}
