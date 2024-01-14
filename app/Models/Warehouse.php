<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address' ,
        'pincode' ,
        'city',
        'state',
        'country' ,
        'return_address',
        'return_pincode',
        'return_city',
        'return_state',
        'return_country',
        'user_id',
        'default',
        'client'
    ];
}
