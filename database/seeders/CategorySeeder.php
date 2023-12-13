<?php

namespace Database\Seeders;

use App\Models\Category as Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create main categories
        $clothing = $this->createCategory(null, 'Clothing');
        $footwear = $this->createCategory(null, 'Footwear');
        $accessories = $this->createCategory(null, 'Accessories & more');
        $shopByBrands = $this->createCategory(null, 'Shop by brands');

        // Create subcategories for 'Clothing'
        $this->createCategory($clothing, 'All clothing');

        // Create subcategories for 'Footwear'
        $sneakers = $this->createCategory($footwear, 'Sneakers');
        $boots = $this->createCategory($footwear, 'Boots');

        // Create subcategories for 'Accessories & more'
        $this->createCategory($accessories, 'Watches');
        $this->createCategory($accessories, 'Shirts');
        $this->createCategory($accessories, 'T-shirts');
        // Add more subcategories as needed

        // Create subcategories for 'Shop by brands'
        $abcBrand = $this->createCategory($shopByBrands, 'ABC brand');
        $coolBrand = $this->createCategory($shopByBrands, 'Cool brand');
        $watchesBrand = $this->createCategory($shopByBrands, 'Watches Brand');
        $cleanLookBrand = $this->createCategory($shopByBrands, 'Clean look brand');

        // Nest additional subcategories as needed
    }

    private function createCategory($parentCategory=null, $category, $isActive = true)
    {
        return Category::create([
            'category' => $category,
            'parent_id' => $parentCategory ? $parentCategory->id : 5,
            'is_active' => $isActive,
            'done_by' => 0,
        ]);
    }

}
