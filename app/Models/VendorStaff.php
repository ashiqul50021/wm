<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorStaff extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];
    protected $guard= ['vendor'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function vendorrole(){
        return $this->belongsTo(VendorRole::class,'vendor_role_id','id');
    }
}
