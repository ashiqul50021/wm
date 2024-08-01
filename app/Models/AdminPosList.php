<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPosList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function adminPosProduct()
    {
        return $this->hasMany(AdminPosListProduct::class,'list_id','id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
