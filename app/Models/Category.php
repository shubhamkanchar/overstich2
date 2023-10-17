<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[
        'category',
        'parent_id',
        'is_active',
        'done_by'
    ];

    public function parentCategory(){
        return $this->hasOne(Category::class,'id','parent_id');
    }
}
