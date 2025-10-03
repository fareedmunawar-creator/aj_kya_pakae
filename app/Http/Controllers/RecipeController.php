<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecipeController extends Controller
{

    
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $query = Recipe::with('ingredients')
            ->withCount('favorites')
            ->latest();
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        $recipes = $query->paginate(10);
        $day = $request->query('day');
        $categories = Category::all();
        $favoriteIds = Auth::user()
            ->favorites()
            ->pluck('recipes.id')
            ->toArray();
        return view('recipes.index', compact('recipes', 'day', 'categories', 'favoriteIds'));
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

        return redirect()->route('recipes.index')->with('success', 'Recipe created!');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load('ingredients', 'comments.user', 'favorites');
        $isFavorite = Auth::check() && Auth::user()->favorites()->where('recipe_id', $recipe->id)->exists();
        return view('recipes.show', compact('recipe', 'isFavorite'));
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
