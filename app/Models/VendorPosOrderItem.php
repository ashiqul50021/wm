<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPosOrderItem extends Model
{
    use HasFactory;

    public function vendorPosOrder(){
    	return $this->belongsTo(VendorPosOrder::class,'vendor_pos_order_id','id');
    }
}
