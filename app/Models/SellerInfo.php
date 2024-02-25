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
        'gst_address',
        'gst_name',
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
        'gst_doc',
        'noc_doc',
        'account_holder_name',
        'bank_name',
        'account_type',
        'owner_name',
        'owner_contact',
        'organization_name',
        'cancel_cheque',
    ];

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sellerInfo) {
            $sellerInfo->slug = Str::slug($sellerInfo->brand, '-');
        });
    }
}
