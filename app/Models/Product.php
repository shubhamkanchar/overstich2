<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    public function images():HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function sizes():HasMany
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function masterCategory()
    {
        return $this->belongsTo(Category::class, 'master_category_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function ratings() {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }

    public function brand() {
        return $this->belongsTo(SellerInfo::class, 'seller_id', 'seller_id');
    }

    public function filters() {
        return $this->hasMany(ProductFilter::class, 'product_id', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->title.'-'.$product->color.'-'.$product->brand, '-', );
        });
    }


}
