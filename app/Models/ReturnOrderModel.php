<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderModel extends Model
{
    protected $fillable = [
        'order_id',
        'seller_id',
        'status',
        'return_reason',
        'other_reason',
        'status_condition',
        'rejected_reason'
    ];
    use HasFactory;

    public function orderDetails(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function payments()
    {
        return $this->hasOne(Payment::class,'order_id','order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
}
