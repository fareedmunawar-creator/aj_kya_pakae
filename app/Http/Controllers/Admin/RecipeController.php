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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'cooking_time' => 'required|integer|min:1',
            'difficulty' => 'required|string|in:easy,medium,hard',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'servings' => 'nullable|integer|min:1',
        ]);
        
        $data = $request->only('title', 'description', 'instructions', 'category_id', 'cooking_time', 'difficulty', 'servings');
        $data['user_id'] = auth()->id();
        
        // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('recipes', $imageName, 'public');
        $data['image_path'] = 'recipes/' . $imageName;
    }
        
        // Ensure category_id is set
        if (!isset($data['category_id'])) {
            // Get the first category as default
            $defaultCategory = Category::first();
            if ($defaultCategory) {
                $data['category_id'] = $defaultCategory->id;
            }
        }
        
        $recipe = Recipe::create($data);

        // Attach ingredients if provided
        if ($request->has('ingredients')) {
            $recipe->ingredients()->sync($request->ingredients);
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
