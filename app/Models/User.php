<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
	    'username',
        'email',
        'address',
        'phone',
        'role',
        'is_approved',
	    'profile_image',
        'password',
        'vendor_id',
        'seller_id',

    ];
    // protected $guard= 'admin';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }


    public function vendorStaff()
    {
        return $this->hasOne(VendorStaff::class);
    }


    public function worker()
    {
        return $this->hasOne(Worker::class);
    }
    public function seller()
    {
        return $this->hasOne(Seller::class, 'user_id');
    }



    public function dealerDue()
    {
        return $this->hasMany(DealerRequestDueProduct::class,'user_id');
    }
}
