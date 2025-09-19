<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Aloo', 'unit' => 'kg'],
            ['name' => 'Pyaz', 'unit' => 'kg'],
            ['name' => 'Tomato', 'unit' => 'kg'],
            ['name' => 'Chicken', 'unit' => 'kg'],
            ['name' => 'Daal', 'unit' => 'kg'],
            ['name' => 'Masale', 'unit' => 'g'],
        ];

        foreach ($ingredients as $ing) {
            Ingredient::create($ing);
        }
    }
}