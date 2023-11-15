<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required',
            'brand' => 'required',
            'category_id' => 'required',
            'child_category_id' => 'required',
            'size' => 'required',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|min:1',
            'discount' => 'nullable|numeric|min:0|max:100',
            'condition' => 'required',
            'status' => 'required'
        ];

        if ($this->has('product_images')) {
            $rules['product_images'] = 'required|array|size:5'; 
            $rules['product_images.*'] = 'image'; 
        }
        
        return $rules;

    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'brand.required' => 'Brand is required.',
            'category_id.required' => 'Category is required.',
            'child_category_id.required' => 'Sub Category is required.',
            'size.required' => 'Size is required.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Please enter a valid number.',
            'stock.required' => 'Stock is required.',
            'stock.min' => 'Stock must be at least 1.',
            'discount.numeric' => 'Please enter a valid number.',
            'condition.required' => 'Condition is required.',
            'status.required' => 'Status is required.',
        ];
    }
}
