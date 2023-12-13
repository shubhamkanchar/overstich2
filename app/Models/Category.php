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

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('children');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->where('status', 'active');
    }

    public function categoryTreeView($categories, $id) {
        $html = '';
        $html .= $this->makechildcat($categories, $id);
        return $html;
    }

    public function makechildcat($categories, $id = null)
    {
        $html = '';
        foreach($categories as $category){
            $count = count($category->children);            
            $colstart = '';            
            $colEnd = '';
            $class = '';
            if($category->parent_id == $id) {
                $colstart = '<div class="col-sm-12 col-md text-start text-md-center">';            
                $colEnd = '</div>';
                $class = 'fs-4 fw-bold';
            }         
            $html .= $colstart;
            $html .= '<a class="nav-link ms-5 me-5 '.$class.'" href="'.route('products.index', $category->id).'">'.$category->category.'</a>';

            if(count($category->children) > 0 ) { 
                $html .= $this->makechildcat($category->children);
            }
            $html .= $colEnd;
        }        
        return $html;
    }
    

}
