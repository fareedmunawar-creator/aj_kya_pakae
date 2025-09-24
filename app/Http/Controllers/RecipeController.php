<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $recipes = Recipe::with('ingredients')->latest()->paginate(10);
        $day = $request->query('day');
        $categories = Category::all();
        return view('recipes.index', compact('recipes', 'day', 'categories'));
    }

    public function create()
    {
        // Only allow admin users to create recipes
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('recipes.index')
                ->with('error', 'Only administrators can create recipes.');
        }
        
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('recipes.create', compact('categories', 'ingredients'));
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
        
        // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('recipes', $imageName, 'public');
        $data['image_path'] = 'recipes/' . $imageName;
    }
        
        $recipe->update($data);

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
