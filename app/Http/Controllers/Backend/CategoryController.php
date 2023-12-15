<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerCategoryTableDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
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
        return $datatable->render('backend.seller.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::with('children')->get();
        return view('backend.seller.category.add',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::where('category',$request->name)->get();
        if( count($category) == 0 ){
            $category = Category::create([
                'category' => $request->name,
                'parent_id' => $request->parent_id,
                'is_active' => (int)$request->is_active,
                'done_by' => Auth::user()->id
            ]);
            notify()->success('Category added successfully');
        }else{
            notify()->error('Category already exists');
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
        $categories = Category::all();
        return view('backend.seller.category.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $categories = Category::where('id','!=',$category->id)->where('category',$request->name)->get();
        if( count($categories) == 0 ){
                $category->category = $request->name;
                $category->parent_id = $request->parent_id;
                $category->is_active = (int)$request->is_active;
                $category->done_by = Auth::user()->id;
                $category->save();
            notify()->success('Category updated successfully');
        }else{
            notify()->error('Category already exists');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            if($category->done_by == Auth::user()->id){
                $category->delete();
                notify()->success('Category Deleted successfully');
            }
            notify()->error("Can't Delete Category Created By Others");
        } catch(Exception $e) {
            notify()->error('Category already exists');
        }

        return redirect()->back();

    }
}
