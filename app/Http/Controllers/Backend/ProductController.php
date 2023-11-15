<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SellerProductDataTable $datatable)
    {
        return $datatable->render('backend.seller.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::whereNull('parent_id')->get();
        $subCategory = Category::whereNotNull('parent_id')->get();
        return view('backend.seller.product.add',compact('category', 'subCategory'));//
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SellerProductRequest $request)
    {
        $user = auth()->user();
    
        DB::beginTransaction(); 

        try {
            $product = new Product();
            $product->title = $request->title;
            $product->seller_id = $user->id;
            $product->brand = $request->brand;
            $product->category_id = $request->category_id;
            $product->child_category_id = $request->child_category_id;
            $product->size = $request->size;
            $product->color = $request->color;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->discount = $request->discount;
            $product->condition = $request->condition;
            $product->status = $request->status;
            $product->description = $request->description;
        
            $product->save();
        
            if ($request->hasFile('product_images')) {
                $images = $request->file('product_images');
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('image/seller/' . $user->name . '/' . $product->title), $imageName);
        
                        $productImage = new ProductImage();
                        $productImage->image_path = 'image/seller/' . $user->name . '/' . $product->title . '/' . $imageName;
                        $product->images()->save($productImage);
                    } else {
                        DB::rollBack();
                        notify()->error('Please add valid images');
                        return redirect()->back();
                    }
                }
            } 
            DB::commit(); 
            notify()->success('Product added successfully');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack(); 
            notify()->error('An error occurred while adding the product');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // $this->authorize('update', $product);
        $category = Category::whereNull('parent_id')->get();
        $subCategory = Category::whereNotNull('parent_id')->get();
        return view('backend.seller.product.edit',compact('product', 'category', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SellerProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $user = auth()->user();
        $product->title = $request->title;
        $product->seller_id = $user->id;
        $product->brand = $request->brand;
        $product->category_id = $request->category_id;
        $product->category_id = $request->category_id;
        $product->child_category_id = $request->child_category_id;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->condition = $request->condition;
        $product->status = $request->status;
        $product->description = $request->description;
    
        $product->update();
        
        notify()->success('Product updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('update', $product);
        $user = auth()->user();
        if (!$product) {
            notify()->error('Product not found.');
            return redirect()->back()->with('error', 'Product not found.');
        }

        foreach ($product->images as $image) {
            $imagePath = public_path($image->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath); 
            }
        }

        rmdir(public_path('image/seller/'.$user->name.'/'.$product->title));
        $product->images()->delete();
        $product->delete();
        notify()->success('Product deleted successfully.');
        return redirect()->route('seller.products.index');
    }

    public function getSubCategory(Category $category) 
    {
        return response()->json($category->children->pluck('category', 'id'), 200);
    }

    public function getImages(Product $product){
        $this->authorize('update', $product);
        $productImages = $product->images;
        return view('backend.seller.product.product-images',compact('product', 'productImages'));
    }

    public function replaceImage(Product $product, ProductImage $productImage, Request $request)
    {
        $user = auth()->user();
        DB::beginTransaction();
        $this->authorize('update', $productImage->product);

        $request->validate([
            'new_image' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        try {

            $newImage = $request->file('new_image');
            $imageName = uniqid() . '.' . $newImage->getClientOriginalExtension();
            $newImage->move(public_path('image/seller/' . $user->name . '/' . $product->title), $imageName);
            $oldImagePath = "";
            if ($productImage->image_path) {
                $oldImagePath = public_path($productImage->image_path);
            }
            
            $productImage->image_path = 'image/seller/' . $user->name . '/' . $product->title .  '/' . $imageName;
            $productImage->save(); 
            DB::commit();
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            notify()->success('Image replaced successfully');
        } catch (Exception $e) {
            DB::rollBack(); 
            notify()->error('An error occurred while replacing old image');
            return redirect()->back();
        }

        return redirect()->back();
    }
}
