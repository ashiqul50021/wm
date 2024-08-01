<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'seller_id','id');
    }
    public function userName(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function brand(){
    	return $this->belongsTo(Brand::class,'brand_id','id');
    }
    public function unit(){
    	return $this->belongsTo(Unit::class,'unit_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function dealer_requests()
    {
        return $this->hasMany(DealerRequest::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function staff(){
    	return $this->belongsTo(Staff::class,'staff_id','id');
    }

    public function multi_imgs()
    {
        return $this->hasMany(MultiImg::class);
    }


    public function productMenufacture()
    {
        return $this->hasOne(ProductMenufactureInfo::class);
    }

    public function manufactureProduct()
    {
        return $this->hasOne(ManufactureProduct::class);
    }


    public function productReview()
    {
        return $this->hasOne(ProductReview::class);
    }

}
