<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userOrderBy()
    {
        return $this->belongsTo(User::class,'order_by','id');
    }
    public function userCollectedBy()
    {
        return $this->belongsTo(User::class,'collected_by','id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
