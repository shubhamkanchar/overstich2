<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPlatformFee extends Model
{
    use HasFactory;
    protected $casts = [
        'invoice_generated_at' => 'datetime', 
    ];
}
