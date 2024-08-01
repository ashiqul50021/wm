<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPosList extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    public function vendorPosProduct()
    {
        return $this->hasMany(VendorPosListProduct::class,'list_id','id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
