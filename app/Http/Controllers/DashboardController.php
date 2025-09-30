<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\PantryItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on user role.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            // Get counts for admin dashboard stats
            $recipeCount = Recipe::count();
            $userCount = User::count();
            $ingredientCount = Ingredient::count();
            $pantryItemCount = PantryItem::count();
            
            // Get top 5 recipes by views
            $topRecipes = Recipe::withCount('views as views_count')
                ->orderByDesc('views_count')
                ->take(5)
                ->get(['id', 'title']);
                
            // Get recent users
            $recentUsers = User::latest()
                ->take(5)
                ->get(['id', 'name', 'email', 'created_at']);
                
            // Get expiring pantry items (next 7 days)
            $expiringItems = PantryItem::whereDate('expiry_date', '<=', Carbon::now()->addDays(7))
                ->with(['user', 'ingredient'])
                ->take(5)
                ->get(['id', 'ingredient_id', 'expiry_date', 'user_id']);
            
            return view('dashboard', compact(
                'userCount', 
                'recipeCount', 
                'ingredientCount', 
                'pantryItemCount',
                'topRecipes',
                'recentUsers',
                'expiringItems'
            ));
        } else {
            // Regular user dashboard
            $userId = auth()->id();
            
            // Get user's meal plans
            $mealPlans = \App\Models\MealPlan::where('user_id', $userId)
                ->with('recipes')
                ->orderBy('day')
                ->get();
                
            // Get user's favorite recipes
            $favoriteRecipes = \App\Models\Recipe::whereHas('favorites', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->take(5)->get();
            
            // Get user's pantry items that are expiring soon
            $pantryItems = PantryItem::where('user_id', $userId)
                ->whereDate('expiry_date', '<=', Carbon::now()->addDays(7))
                ->with('ingredient')
                ->orderBy('expiry_date')
                ->get();
            
            return view('dashboard', compact('mealPlans', 'favoriteRecipes', 'pantryItems'));
        }
    }
}