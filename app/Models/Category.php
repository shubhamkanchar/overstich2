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

    public function allChildrenId()
    {
        $ids = $this->getAllIds($this->children);
        $ids[] = $this->id;
        return $ids;
    }

    public function getAllIds($categories) {
        $ids = [];
        foreach($categories as $category) {
            $ids[] = $category->id;
            if(count($category->children) > 0 ) { 
                $ids = array_merge($ids, $this->getAllIds($category->children));
            }
        }

        return $ids;
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
            $class = 'fs-6';
            $caret = $count > 0 ? '<span class="bi bi fs-4 text-secondary me-5 d-inline-block d-md-none align-self-center show-nested-subcategory" data-target="#subcategories'. $category->id.'"> > </span>' : '';

            if($category->parent_id == $id) {
                $colstart = '<div class="col-sm-12 col-md-2 text-start">';            
                $colEnd = '</div>';
                $class = 'fs-md-4  fs-6 fw-md-bold fw-semibold align-self-center';
            }         

            $html .= $colstart;
            $html .= '<div class="d-flex justify-content-between"> <a class="nav-link ms-5 me-1 mb-1 d-inline-block '.$class.'" href="'.route('products.index', $category->id).'">'. ucfirst($category->category) .'</a>'.$caret.'</div>';

            if($count > 0 ) {
                $html .= '<div id="subcategories'. $category->id.'" class="childs d-none d-md-inline-block">' ;
                $html .= $this->makechildcat($category->children);
                $html .= '</div>';
            }
            $html .= $colEnd;
        }        
        return $html;
    }
    

}
