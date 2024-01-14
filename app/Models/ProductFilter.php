<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    use HasFactory;
    protected $fillable =[
        'value',
        'filter_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function categoryFilter()
    {
        return $this->belongsTo(categoryFilter::class, 'filter_id', 'id');
    }
}
