<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'size',
        'name',
        'price',
        'original_price',
        'discount_percentage',
        'discount',
        'quantity',
        'total_discount',
        'total_original_price',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function saveFromCart($item, $orderId)
    {
        $this->fill([
            'order_id' => $orderId,
            'product_id' => $item->options?->product_id,
            'name' => $item->name,
            'price' => $item->price,
            'original_price' => $item->options?->original_price,
            'discount_percentage' => $item->options?->discount_percentage,
            'discount' => $item->options?->discount,
            'quantity' => $item->qty,
            'total_discount' => $item->options?->discount * $item->qty,
            'total_price' => $item->price * $item->qty,
            'total_original_price' => $item->options?->original_price * $item->qty,
            'size' => $item->options?->size,
        ])->save();
    }
}
