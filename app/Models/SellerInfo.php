<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 

class SellerInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'brand',
        'gst',
        'slug',
        'whatsapp',
        'category',
        'products',
        'price_range',
        'address',
        'locality',
        'city',
        'state',
        'pincode',
        'account',
        'is_approved',
        'ifsc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sellerInfo) {
            $sellerInfo->slug = Str::slug($sellerInfo->brand, '-');
        });
    }
}
