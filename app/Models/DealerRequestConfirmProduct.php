<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerRequestConfirmProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function requestConfirm(){
        return $this->belongsTo(DealerRequestConfirm::class, 'request_confirm_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
