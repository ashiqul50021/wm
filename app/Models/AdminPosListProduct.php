<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPosListProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function adminPosList()
    {
        return $this->belongsTo(AdminPosList::class,'list_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
