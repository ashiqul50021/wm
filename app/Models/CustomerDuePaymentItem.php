<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDuePaymentItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function posOrder(){
    	return $this->belongsTo(PosOrder::class,'pos_order_id','id');
    }
}
