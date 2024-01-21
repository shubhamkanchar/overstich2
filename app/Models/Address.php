<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'address',
        'city',
        'state',
        'pincode',
        'locality',
        'user_id',
        'default'
    ];

    protected static function boot()
    {
        parent::boot();

        // Creating event
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
