<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ingredient;
use App\Models\PantryItem;
use Illuminate\Support\Facades\Auth;

class QuickCookController extends Controller
{
    public function findRecipes(Request $request)
    {
        // If it's a GET request, show the form
        if ($request->isMethod('get')) {
            // Get all ingredients for the form
            $ingredients = Ingredient::all();
            
            // Get user's pantry items if authenticated
            $userPantryIngredients = [];
            if (Auth::check()) {
                $userPantryIngredients = PantryItem::where('user_id', Auth::id())
                    ->with('ingredient')
                    ->get()
                    ->pluck('ingredient_id')
                    ->toArray();
            }
            
            return view('recipes.quick-cook', compact('ingredients', 'userPantryIngredients'));
        }
        
        // For POST requests, process the recipe search
        $pantryIngredientIds = $request->input('ingredients', []);

        if (empty($pantryIngredientIds)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'No pantry ingredients provided'], 400);
            }
            return redirect()->back()->with('error', 'Please select at least one ingredient.');
        }

        $recipes = DB::table('recipes')
            ->join('ingredient_recipe', 'recipes.id', '=', 'ingredient_recipe.recipe_id')
            ->select(
                'recipes.id',
                'recipes.name',
                'recipes.popularity',
                DB::raw('COUNT(CASE WHEN ingredient_recipe.ingredient_id IN (' . implode(',', $pantryIngredientIds) . ') THEN 1 END) as matched_count'),
                DB::raw('COUNT(ingredient_recipe.ingredient_id) as total_required')
            )
            ->groupBy('recipes.id', 'recipes.name', 'recipes.popularity')
            ->get()
            ->map(function ($recipe) use ($pantryIngredientIds) {
                $recipe->match_score = ($recipe->total_required > 0)
                    ? round(($recipe->matched_count / $recipe->total_required) * 100, 2)
                    : 0;

                // Find missing ingredients
                $missing = DB::table('ingredient_recipe')
                    ->join('ingredients', 'ingredient_recipe.ingredient_id', '=', 'ingredients.id')
                    ->where('ingredient_recipe.recipe_id', $recipe->id)
                    ->whereNotIn('ingredient_recipe.ingredient_id', $pantryIngredientIds)
                    ->pluck('ingredients.name');

                $recipe->missing_ingredients = $missing;

                return $recipe;
            })
            ->sortByDesc(function ($recipe) {
                return [$recipe->match_score, $recipe->popularity];
            })
            ->values();

        return response()->json($recipes);
    }
}
