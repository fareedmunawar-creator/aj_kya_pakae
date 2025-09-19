<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Desi', 'description' => 'Traditional Pakistani/Indian food.'],
            ['name' => 'Quick Meals', 'description' => 'Easy 30-min recipes.'],
            ['name' => 'Snacks', 'description' => 'Light bites and evening treats.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}