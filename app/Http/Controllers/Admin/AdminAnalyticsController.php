<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\PantryItem;
use App\Models\User;
use App\Models\SearchLog;

class AdminAnalyticsController extends Controller
{
    /**
     * Display the admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get counts for dashboard stats
        $recipeCount = Recipe::count();
        $userCount = User::count();
        $ingredientCount = Ingredient::count();
        
        return view('admin.dashboard', compact('recipeCount', 'userCount', 'ingredientCount'));
    }
    
    // 1. Top 10 recipes by views
    public function topRecipes()
    {
        $recipes = Recipe::orderByDesc('views')
            ->take(10)
            ->get(['title', 'views']);

        return response()->json($recipes);
    }

    // 2. Ingredient usage frequency
    public function ingredientUsage()
    {
        $usage = DB::table('ingredient_recipe')
            ->select('ingredients.name', DB::raw('COUNT(ingredient_recipe.ingredient_id) as usage_count'))
            ->join('ingredients', 'ingredient_recipe.ingredient_id', '=', 'ingredients.id')
            ->groupBy('ingredients.name')
            ->orderByDesc('usage_count')
            ->take(10)
            ->get();

        return response()->json($usage);
    }

    // 3. Expiring pantry items (next 7 days)
    public function expiringPantry()
    {
        $items = PantryItem::whereDate('expiry_date', '<=', Carbon::now()->addDays(7))
            ->with(['user', 'ingredient'])
            ->get(['id','ingredient_id','expiry_date','user_id']);

        return response()->json($items);
    }

    // 4. Search trends (last 30 days)
    public function searchTrends()
    {
        $trends = SearchLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as searches')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($trends);
    }

    // 5. Active users trend (last 30 days)
    public function activeUsers()
    {
        $users = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as active_users')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($users);
    }

    // Additional dashboard analytics methods can be added here
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
        
        return view('admin.dashboard', compact(
            'userCount', 
            'recipeCount', 
            'ingredientCount', 
            'pantryItemCount',
            'topRecipes',
            'recentUsers',
            'expiringItems'
        ));
    }
}
