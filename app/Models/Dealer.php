<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $guard = ['dealer'];
    protected $fillable = [
        'name',
        'shop_name',
        'address',
        'description',
        'bank_name',
        'bank_account',
        'bank_account_img',
        'google_map_url',
        'nid',
        'shop_image',
        'trade_license',
        'profile_image',
        'status',
        'user_id',
        'created_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
