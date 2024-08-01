<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDuePayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function customerDueItem(){
        return $this->hasMany(CustomerDuePaymentItem::class, 'customer_due_id');
    }

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
}
