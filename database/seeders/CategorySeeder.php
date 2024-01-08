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
        $categoryNames = ['Mens', 'Womens', 'Kids'];
        
        foreach ($categoryNames as $categoryName) {
            Category::firstOrCreate(['category' => $categoryName], [
                'parent_id' => null,
                'is_active' => 1,
                'done_by' => 1,
            ]);
        }
    }


}
