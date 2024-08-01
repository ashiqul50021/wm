<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDueCollect extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'customer_due_collect';

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class,'collected_by');
    }


}
