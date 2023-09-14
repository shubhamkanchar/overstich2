<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'gst',
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
}
