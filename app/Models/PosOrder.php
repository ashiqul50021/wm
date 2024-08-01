<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posOrderItem()
    {
        return $this->hasMany(PosOrderItem::class,'pos_order_id');
    }

    public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }


    public function seller(){
        return $this->belongsTo(Vendor::class,'seller_id','id');
    }

    public function saleby(){
        return $this->belongsTo(User::class, 'sale_by');
    }


}
