<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'seller_id',
        'product_id',
        'shipping_id',
        'email',
        'batch',
        'phone', 
        'address', 
        'locality',
        'pincode',
        'city' ,
        'state' ,
        'country' ,
        'order_number',
        'payment_method',
        'payment_transaction_id',
        'is_order_confirmed',
        'total_amount' ,
        'delivery_charge' ,
        'sub_total',
        'status',
        'total_discount',
        'ewaybill'
    ];

    protected $casts = [
        'invoice_generated_at' => 'datetime', 
    ];

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class, 'order_id', 'id');
    }

    public function payments()
    {
        return $this->hasOne(Payment::class);
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
