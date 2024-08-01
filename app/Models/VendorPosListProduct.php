<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPosListProduct extends Model
{
    use HasFactory;
    protected $guarded  = ['id'];

    public function vendorPosList()
    {
        return $this->belongsTo(VendorPosList::class,'list_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
