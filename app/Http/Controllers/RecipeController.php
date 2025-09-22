<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::with('ingredients')->latest()->paginate(10);
        $day = $request->query('day');
        $categories = Category::all();
        return view('recipes.index', compact('recipes', 'day', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('recipes.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $data = $request->only('title', 'description', 'instructions', 'category_id', 'cooking_time', 'difficulty');
        $data['user_id'] = auth()->id();
        
        $recipe = Recipe::create($data);

        // Attach ingredients if provided
        if ($request->has('ingredients')) {
            $recipe->ingredients()->sync($request->ingredients);
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe created!');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load('ingredients', 'comments.user', 'favorites');
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $categories = Category::all();
        $allIngredients = Ingredient::all();
        return view('recipes.edit', compact('recipe', 'categories', 'allIngredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $recipe->update($request->only('title', 'description', 'instructions', 'category_id', 'cooking_time', 'difficulty'));

        if ($request->has('ingredients')) {
            $recipe->ingredients()->sync($request->ingredients);
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe updated!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted!');
    }
}
