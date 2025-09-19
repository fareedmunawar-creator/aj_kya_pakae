<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have a test user
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Fetch categories
        $desi = Category::where('name', 'Desi')->first();
        $quick = Category::where('name', 'Quick Meals')->first();
        $snacks = Category::where('name', 'Snacks')->first();

        // Fetch ingredients
        $aloo = Ingredient::where('name', 'Aloo')->first();
        $pyaz = Ingredient::where('name', 'Pyaz')->first();
        $tomato = Ingredient::where('name', 'Tomato')->first();
        $chicken = Ingredient::where('name', 'Chicken')->first();
        $daal = Ingredient::where('name', 'Daal')->first();
        $masale = Ingredient::where('name', 'Masale')->first();

        // 1️⃣ Aloo Gosht
        $recipe1 = Recipe::create([
            'user_id' => $user->id,
            'category_id' => $desi->id,
            'title' => 'Aloo Gosht',
            'description' => 'Classic desi curry with mutton and potatoes.',
            'image_path' => 'images/aloo_gosht.jpg',
            'cooking_time' => 60,
            'servings' => 4,
        ]);
        $recipe1->ingredients()->attach([
            $aloo->id => ['quantity' => 0.5],
            $pyaz->id => ['quantity' => 0.25],
            $tomato->id => ['quantity' => 0.25],
            $masale->id => ['quantity' => 50],
        ]);

        // 2️⃣ Chicken Karahi
        $recipe2 = Recipe::create([
            'user_id' => $user->id,
            'category_id' => $quick->id,
            'title' => 'Chicken Karahi',
            'description' => 'Quick spicy chicken karahi.',
            'image_path' => 'images/chicken_karahi.jpg',
            'cooking_time' => 40,
            'servings' => 3,
        ]);
        $recipe2->ingredients()->attach([
            $chicken->id => ['quantity' => 1],
            $pyaz->id => ['quantity' => 0.25],
            $tomato->id => ['quantity' => 0.5],
            $masale->id => ['quantity' => 30],
        ]);

        // 3️⃣ Daal Fry
        $recipe3 = Recipe::create([
            'user_id' => $user->id,
            'category_id' => $snacks->id,
            'title' => 'Daal Fry',
            'description' => 'Comfort food – spicy daal fry with masala tadka.',
            'image_path' => 'images/daal_fry.jpg',
            'cooking_time' => 30,
            'servings' => 2,
        ]);
        $recipe3->ingredients()->attach([
            $daal->id => ['quantity' => 0.5],
            $pyaz->id => ['quantity' => 0.2],
            $tomato->id => ['quantity' => 0.2],
            $masale->id => ['quantity' => 20],
        ]);
    }
}