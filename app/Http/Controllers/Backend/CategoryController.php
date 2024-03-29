<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryFilterDataTable;
use App\DataTables\SellerCategoryTableDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryFilter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SellerCategoryTableDataTable $datatable)
    {
        return $datatable->render('backend.admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::whereNull('parent_id')->get();
        $subCategory = Category::whereNull('subcategory_id')->whereNotNull('parent_id')->get();
        return view('backend.admin.category.add',compact('category','subCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(empty($request->subcategory_id)) {
            $category = Category::where('category',$request->name)->where('parent_id', $request->parent_id)->get();
        } else  {
            $category = Category::where('category',$request->name)->where(['parent_id' => $request->parent_id, 'subcategory_id' => $request->subcategory_id])->get();
        }
        if( count($category) == 0 ){
            $category = Category::create([
                'category' => $request->name,
                'parent_id' => $request->parent_id,
                'subcategory_id' => $request->subcategory_id,
                'is_active' => (int)$request->is_active,
                'done_by' => Auth::user()->id
            ]);

            // $filterTypes = $request->types;
            // $filterValues = $request->type_values;
            // foreach($filterTypes as $key => $type) {
            //     $categoryFilter = new CategoryFilter();
            //     $categoryFilter->category_id = $category->id;
            //     $categoryFilter->type = $type;
            //     $categoryFilter->value = json_encode(explode(',',$filterValues[$key]));
            //     $categoryFilter->save();
            // }
            request()->session()->put('success','Category added successfully');
        } else{
            // request()->session()->put('error','Category already exists');
            request()->session()->put('error','Category already exists');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // $category = Category::all();
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->with('subCategory', 'filters')->get();
        $subCategory = Category::where('parent_id', $category->parent_id)->whereNotNull('parent_id')->whereNull('subcategory_id')->get();
        return view('backend.admin.category.edit', compact('category','categories', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if(empty($request->subcategory_id)) {
            $categories = Category::where('id','!=',$category->id)->where('category',$request->name)->where('parent_id', $request->parent_id)->get();
        } else  {
            $categories = Category::where('id','!=',$category->id)->where('category',$request->name)->where(['parent_id' => $request->parent_id, 'subcategory_id' => $request->subcategory_id])->get();
        }
        if( count($categories) <= 1 ){
                $category->category = $request->name;
                $category->parent_id = $request->parent_id;
                $category->subcategory_id = $request->subcategory_id;
                $category->is_active = (int)$request->is_active;
                $category->done_by = Auth::user()->id;
                $category->save();
                // $filterTypes = $request->types;
                // $filterValues = $request->type_values;
                // $filterIds = $request->filter_id;
                // if($filterIds) {
                //     $category->filters()->whereNotIn('id', $filterIds)->delete();
                // }
                
                // foreach($filterTypes as $key => $type) {
                //     $categoryFilter = new CategoryFilter();
                //     if(isset($filterIds[$key])) {
                //         $categoryFilter = CategoryFilter::find($filterIds[$key]);
                //     }
                //     $categoryFilter->category_id = $category->id;
                //     $categoryFilter->type = $type;
                //     $categoryFilter->value = json_encode(explode(',',$filterValues[$key]));
                //     $categoryFilter->save();
                // }
            request()->session()->put('success','category updated');
        } else{
            request()->session()->put('error','Category already exists');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $categoryIds = [$category->id];
            $categoryIds = array_merge($categoryIds, $category->allChildrenId());
            Category::whereIn('id', $categoryIds)->delete();
            return response()->json(['message' => 'Category Deleted Successfully'], 200);
        } catch(Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 400);
        }

        return redirect()->back();

    }

    public function getSubCategory(Category $category) 
    {
        return response()->json($category->subCategory->pluck('category', 'id'), 200);
    }

    public function getchildCategory(Category $category) 
    {
        return response()->json($category->childCategory->pluck('category', 'id'), 200);
    }

    public function viewFilters(CategoryFilterDataTable $datatable) {
        return $datatable->render('backend.admin.filter.index');
    }

    public function addFilter() {
        $categories = Category::whereNull('parent_id')->get();
        return view('backend.admin.filter.add', compact('categories'));
    }

    public function editFilter(CategoryFilter $categoryFilter) {
        $categories = Category::whereNull('parent_id')->get();
        return view('backend.admin.filter.edit', compact('categories','categoryFilter'));
    }

    public function storeFilter(Request $request) {
        $categoryFilter = CategoryFilter::where('type', $request->type)->where('category_id', $request->category_id)->get();
        if(count($categoryFilter) == 0 ){
            $categoryFilter = new CategoryFilter();
            $categoryFilter->category_id = $request->category_id;
            $categoryFilter->type = $request->type;
            $categoryFilter->value = json_encode(explode(',',$request->type_values));
            $categoryFilter->save();
            return redirect()->back()->with('success', 'Filter added success');
        } else {
            return redirect()->back()->with('error', 'Filter Already Exists');
        }
    }

    public function updateFilter(CategoryFilter $categoryFilter,Request $request) {
        $alreadyExists = CategoryFilter::where('id', '!=', $categoryFilter->id)->where('type', $request->type)->where('category_id', $request->category_id)->get();
        if(count($alreadyExists) == 0 ){
            $categoryFilter->category_id = $request->category_id;
            $categoryFilter->type = $request->type;
            $categoryFilter->value = json_encode(explode(',', $request->type_values));
            $categoryFilter->update();
            return redirect()->back()->with('success', 'Filter updated success');

        } else {
            return redirect()->back()->with('error', 'Filter Already Exists');
        }
    }

    public function destroyFilter(CategoryFilter $categoryFilter)
    {
        try {
            $categoryFilter->delete();
            return response()->json(['message' => 'Filter Deleted Successfully'], 200);
        } catch(Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 400);
        }

        return redirect()->back();

    }
}
