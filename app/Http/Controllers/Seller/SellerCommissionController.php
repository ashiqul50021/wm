<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerCommission;
use Illuminate\Http\Request;

class SellerCommissionController extends Controller
{
    public function sellerCommission(){
        $sellerCommission = SellerCommission::all();
        return view('seller.template.commission.commission_view',compact('sellerCommission'));
    }
}
