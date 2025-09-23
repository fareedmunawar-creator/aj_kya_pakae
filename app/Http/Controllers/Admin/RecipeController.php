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
        $recipe = Recipe::create($request->only('title', 'description', 'instructions'));

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
