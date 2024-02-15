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
        'color',
        'image',
        'name',
        'price',
        'original_price',
        'discount_percentage',
        'discount',
        'quantity',
        'total_discount',
        'total_original_price',
        'total_price',
        'taxable_amount',
        'striked_price',
        'cgst_percent',
        'sgst_percent',
        'cgst_amount',
        'sgst_amount',
        'hsn'
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
            'original_price' => $item->options?->original_price,//
            'striked_price' => $item->options?->striked_price,//
            'price' => $item->price,
            'discount_percentage' => $item->options?->discount_percentage,
            'discount' => $item->options?->discount,
            'quantity' => $item->qty,
            'taxable_amount' => $item->options?->taxable_amount,
            'cgst_percent' => $item->options?->cgst_percent,
            'sgst_percent' => $item->options?->sgst_percent,
            'cgst_amount' => $item->options?->cgst_amount,
            'sgst_amount' => $item->options?->sgst_amount,
            'total_discount' => $item->options?->discount * $item->qty,
            'total_price' => $item->price * $item->qty,
            'total_original_price' => $item->options?->original_price * $item->qty,
            'size' => $item->options?->size,
            'image' => $item->options?->image,
            'color' => $item->options?->color,
            'hsn' => $item->options?->hsn,
        ])->save();
    }
}
