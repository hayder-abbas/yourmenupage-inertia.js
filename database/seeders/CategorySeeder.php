<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create([
            'cat_name' => 'Vegetable'
        ]);
        Category::factory()->create([
            'cat_name' => 'Meat'
        ]);
        Category::factory()->create([
            'cat_name' => 'Fast food'
        ]);
        Category::factory()->create([
            'cat_name' => 'Hot drinks'
        ]);
        Category::factory()->create([
            'cat_name' => 'Soft drinks'
        ]);
        Category::factory()->create([
            'cat_name' => 'Juices'
        ]);
        Category::factory()->create([
            'cat_name' => 'Ice cream'
        ]);
        Category::factory()->create([
            'cat_name' => 'Seafood'
        ]);
        Category::factory()->create([
            'cat_name' => 'Pastries'
        ]);
        Category::factory()->create([
            'cat_name' => 'Sweets'
        ]);
        Category::factory()->create([
            'cat_name' => 'chickens'
        ]);
    }
}
