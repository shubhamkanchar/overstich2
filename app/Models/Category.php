<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[
        'category',
        'parent_id',
        'subcategory_id',
        'is_active',
        'done_by'
    ];


    public function masterCategory(){
        return $this->hasOne(Category::class,'id','parent_id');
    }

    public function parentSubCategory(){
        return $this->hasOne(Category::class,'id','subcategory_id');
    }

    public function children()
    {
        if(is_null($this->parent_id)) {
            return $this->hasMany(Category::class, 'parent_id', 'id')->whereNull('subcategory_id') ?? $this->hasMany(Category::class, 'subcategory_id', 'id');
        }
        return $this->hasMany(Category::class, 'subcategory_id', 'id');
    }

    public function filters() {
        return $this->hasMany(CategoryFilter::class, 'category_id', 'id');
    }

    public function subCategory() {
        return $this->hasMany(Category::class, 'parent_id', 'id')->whereNull('subcategory_id');
    }

    public function childCategory() {
        return $this->hasMany(Category::class, 'subcategory_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->where('status', 'active');
    }

    public function allChildrenId()
    {
        if(is_null($this->parent_id)) {
            $ids = $this->getAllIds($this->subCategory);
            return $ids;
        }

        $ids = $this->getAllIds($this->childCategory);
        return $ids;
    }

    public function getAllIds($categories) {
        $ids = [];
        foreach($categories as $category) {
            $ids[] = $category->id;
            if(count($category->childCategory) > 0 ) { 
                $ids = array_merge($ids, $this->getAllIds($category->childCategory));
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
            $count = count($category->subCategory ?? $category->childCategory);            
            $colstart = '';            
            $colEnd = '';
            $class = 'fs-6';
            $caret = $count > 0 ? '<span class="bi bi fs-4 text-secondary me-5 d-inline-block d-md-none align-self-center show-nested-subcategory" data-target="#subcategories'. $category->id.'"> > </span>' : '';

            if($category->parent_id == $id && is_null($category->subcategory_id)) {
                $colstart = '<div class="col-sm-12 col-md-2 text-start">';            
                $colEnd = '</div>';
                $class = 'fs-md-4  fs-6 fw-md-bold fw-semibold align-self-center';
            }         

            $html .= $colstart;
            $html .= '<div class="d-flex justify-content-between"> <a class="nav-link ms-5 me-1 mb-1 d-inline-block '.$class.'" href="'.route('products.index', $category->id).'">'. ucfirst($category->category) .'</a>'.$caret.'</div>';

            if($count > 0 ) {
                $html .= '<div id="subcategories'. $category->id.'" class="childs d-none d-md-inline-block">' ;
                $html .= $this->makechildcat($category->subCategory ?? $category->childCategory);
                $html .= '</div>';
            }
            $html .= $colEnd;
        }        
        return $html;
    }
    

}
