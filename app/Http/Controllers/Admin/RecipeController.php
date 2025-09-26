<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('ingredients')->paginate(20);
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('admin.recipes.create');
    }

    public function store(Request $request)
    {
        // Create data array with required fields
        $data = $request->only('title', 'description', 'instructions');
        
        // Add category_id - either from request or default to first category
        if ($request->has('category_id')) {
            $data['category_id'] = $request->category_id;
        } else {
            // Get the first category as default
            $defaultCategory = \App\Models\Category::first();
            if ($defaultCategory) {
                $data['category_id'] = $defaultCategory->id;
            } else {
                // If no categories exist, create one
                $defaultCategory = \App\Models\Category::create(['name' => 'General', 'description' => 'Default category']);
                $data['category_id'] = $defaultCategory->id;
            }
        }
        
        // Add user_id if needed
        $data['user_id'] = auth()->id() ?? 1;
        
        // Add other required fields with default values
        $data['cooking_time'] = $request->cooking_time ?? 30;
        $data['difficulty'] = $request->difficulty ?? 'medium';
        
        $recipe = Recipe::create($data);

        if ($request->has('ingredients')) {
            // Filter out any empty ingredient IDs to prevent SQL errors
            $ingredients = array_filter($request->ingredients, function($value) {
                return !empty($value);
            });
            
            if (!empty($ingredients)) {
                $recipe->ingredients()->sync($ingredients);
            }
        }

        return redirect()->route('admin.recipes.index')->with('success', 'Recipe created!');
    }

    public function edit(Recipe $recipe)
    {
        return view('admin.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $recipe->update($request->only('title', 'description', 'instructions'));

        if ($request->has('ingredients')) {
            // Filter out any empty ingredient IDs to prevent SQL errors
            $ingredients = array_filter($request->ingredients, function($value) {
                return !empty($value);
            });
            
            if (!empty($ingredients)) {
                $recipe->ingredients()->sync($ingredients);
            }
        }

        return redirect()->route('admin.recipes.index')->with('success', 'Recipe updated!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('admin.recipes.index')->with('success', 'Recipe deleted!');
    }
}
