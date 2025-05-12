<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories
        // DB::table('categories')->truncate();
        
        // Create default categories
        $categories = [
            [
                'name' => 'Volleyball',
                'color' => '#2196F3', // Blue
                'description' => 'Volleyball events',
                'created_by' => 1,
            ],
            [
                'name' => 'Football',
                'color' => '#4CAF50', // Green
                'description' => 'Football events',
                'created_by' => 1,
            ],
            [
                'name' => 'Basketball',
                'color' => '#F44336', // Red
                'description' => 'Basketball events',
                'created_by' => 1,
            ],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}