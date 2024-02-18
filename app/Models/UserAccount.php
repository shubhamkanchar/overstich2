<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable = [
        'user_id',
        'holder_name',
        'account_number',
        'bank_name',
        'ifsc'
    ];
    use HasFactory;
}
