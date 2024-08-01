<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $guard= ['worker'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
