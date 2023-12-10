<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function updateQuantity($orderItem) {
        $productSize = ProductSize::where(['product_id' => $orderItem->product_id, 'size' => $orderItem->size ])->first();
        $availableSize = max($productSize->quantity - $orderItem->quantity, 0);
        $productSize->quantity = $availableSize;
        $productSize->update();
        return $productSize;
    }
}
