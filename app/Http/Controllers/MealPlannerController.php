<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MealPlannerController extends Controller
{
    /**
     * Display the meal planner page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $user = Auth::user();
        // Ensure we only get meal plans for the current user
        $mealPlans = MealPlan::where('user_id', Auth::id())->with(['recipes' => function($query) {
            $query->with('media'); // Eager load media for recipe images
        }])->latest()->get();
        
        // Check if user has an active meal plan
        $today = Carbon::today();
        $activeMealPlan = $mealPlans->first(function($mealPlan) use ($today) {
            return $mealPlan->start_date <= $today && $mealPlan->end_date >= $today;
        });
        
        // Define days and meal types
        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
        
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        // Group meal plans by day for the weekly view
        $weeklyMealPlans = [];
        if ($activeMealPlan) {
            // Organize recipes by day and meal type
            foreach ($activeMealPlan->recipes as $recipe) {
                $pivot = $recipe->pivot;
                if (isset($pivot->day) && isset($pivot->meal_type)) {
                    if (!isset($weeklyMealPlans[$pivot->day])) {
                        $weeklyMealPlans[$pivot->day] = [];
                    }
                    $weeklyMealPlans[$pivot->day][] = $activeMealPlan;
                }
            }
        }
        
        // Get recipes for the create form
        $recipes = Recipe::all();
        
        // Check which route was used to access this method
        if (request()->route()->getName() === 'meal-plans.index') {
            // For the meal-plans.index route, use the same view as mealplanner.index
            return view('mealplanner.index', compact('weeklyMealPlans', 'mealPlans', 'days', 'recipes', 'activeMealPlan'));
        }
        
        // For the mealplanner.index route
        return view('mealplanner.index', compact('weeklyMealPlans', 'mealPlans', 'days', 'recipes', 'activeMealPlan'));
    }
    
    /**
     * Show the form for creating a new meal plan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        // Check if user already has an active meal plan or any future meal plan
        $today = Carbon::today();
        $existingPlan = MealPlan::where('user_id', Auth::id())
            ->where(function($query) use ($today) {
                // Check for active plans (current date falls between start and end dates)
                $query->where('start_date', '<=', $today)
                      ->where('end_date', '>=', $today)
                      // Or check for future plans (start date is in the future)
                      ->orWhere('start_date', '>', $today);
            })->first();
            
        if ($existingPlan) {
            if ($existingPlan->start_date <= $today && $existingPlan->end_date >= $today) {
                return redirect()->route('mealplanner.index')
                    ->with('error', __('You already have an active meal plan. Please wait until it ends or delete it before creating a new one.'));
            } else {
                return redirect()->route('mealplanner.index')
                    ->with('error', __('You already have a scheduled meal plan. Please delete it before creating a new one.'));
            }
        }
        
        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
        
        $recipes = Recipe::all();
        
        return view('mealplanner.create', compact('days', 'recipes'));
    }
    
    /**
     * Show the form for editing a meal plan
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified meal plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $mealPlan = MealPlan::with(['recipes' => function($query) {
            $query->with('category'); // Load additional recipe data
        }])->findOrFail($id);
        
        // Define days and meal types
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        // Organize recipes by day and meal type
        $organizedMeals = [];
        foreach ($mealPlan->recipes as $recipe) {
            $pivot = $recipe->pivot;
            $organizedMeals[$pivot->day][$pivot->meal_type] = $recipe;
        }
        
        // Check if the meal plan belongs to the authenticated user
        if ($mealPlan->user_id !== Auth::id()) {
            return redirect()->route('mealplanner.index')
                ->with('error', __('messages.unauthorized'));
        }
        
        // Ensure we have all days and meal types organized
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        // Organize recipes by day and meal type
        $organizedMeals = [];
        foreach ($days as $day) {
            foreach ($mealTypes as $mealType) {
                $organizedMeals[$day][$mealType] = null;
            }
        }
        
        // Fill in the organized meals with actual recipes
        foreach ($mealPlan->recipes as $recipe) {
            $pivot = $recipe->pivot;
            $organizedMeals[$pivot->day][$pivot->meal_type] = $recipe;
        }
        
        return view('mealplanner.show', compact('mealPlan', 'organizedMeals', 'days', 'mealTypes'));
    }
    
    /**
     * Store a newly created meal plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'meals' => 'array'
        ]);
        
        $userId = Auth::id();
        $startDate = Carbon::parse($request->start_date);
        
        // Check if user already has an active meal plan or any future meal plan
        $today = Carbon::today();
        $existingPlan = MealPlan::where('user_id', $userId)
            ->where(function($query) use ($today) {
                // Check for active plans (current date falls between start and end dates)
                $query->where('start_date', '<=', $today)
                      ->where('end_date', '>=', $today)
                      // Or check for future plans (start date is in the future)
                      ->orWhere('start_date', '>', $today);
            })->first();
            
        if ($existingPlan) {
            if ($existingPlan->start_date <= $today && $existingPlan->end_date >= $today) {
                return redirect()->route('mealplanner.index')
                    ->with('error', __('You already have an active meal plan. Please wait until it ends or delete it before creating a new one.'));
            } else {
                return redirect()->route('mealplanner.index')
                    ->with('error', __('You already have a scheduled meal plan. Please delete it before creating a new one.'));
            }
        }
        
        // Calculate end date (7 days from start date)
        $endDate = $startDate->copy()->addDays(6);
        
        $count = 0;
        
        // Create a single meal plan
        $mealPlan = new MealPlan();
        $mealPlan->user_id = $userId;
        $mealPlan->name = $request->name;
        $mealPlan->start_date = $startDate;
        $mealPlan->end_date = $endDate;
        $mealPlan->save();
        
        // Process each day and meal type
        if ($request->has('meals')) {
            foreach ($request->meals as $day => $mealTypes) {
                foreach ($mealTypes as $mealType => $recipeId) {
                    if (!empty($recipeId)) {
                        // Attach recipe to the meal plan with day and meal type
                        $mealPlan->recipes()->attach($recipeId, [
                            'day' => $day,
                            'meal_type' => $mealType
                        ]);
                        $count++;
                    }
                }
            }
        }
        
        $message = $count > 0 
            ? __(':count recipes added to your meal plan', ['count' => $count]) 
            : __('No recipes were selected');
            
        return redirect()->route('mealplanner.index')
            ->with('success', $message);
    }
    
    public function edit(MealPlan $mealPlan)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        // Ensure the meal plan belongs to the current user
        if ($mealPlan->user_id !== Auth::id()) {
            return redirect()->route('mealplanner.index')->with('error', 'You do not have permission to edit this meal plan.');
        }
        
        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
        
        $recipes = Recipe::all();
        
        // Get the meal plan recipes
        $mealPlanRecipes = $mealPlan->recipes;
        
        // Initialize day and mealType variables to prevent undefined variable errors
        $day = request()->query('day', null);
        $mealType = request()->query('meal_type', null);
        
        // Ensure dates are Carbon instances
        if (is_string($mealPlan->start_date)) {
            $mealPlan->start_date = Carbon::parse($mealPlan->start_date);
        }
        
        if (is_string($mealPlan->end_date)) {
            $mealPlan->end_date = Carbon::parse($mealPlan->end_date);
        }
        
        // Organize recipes by day and meal type
        $selectedRecipes = [];
        foreach ($mealPlan->recipes as $recipe) {
            $pivotDay = $recipe->pivot->day;
            $pivotMealType = $recipe->pivot->meal_type;
            $selectedRecipes[$pivotDay][$pivotMealType] = $recipe->id;
        }
        
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        return view('mealplanner.edit', compact('mealPlan', 'days', 'recipes', 'day', 'mealType', 'selectedRecipes', 'mealPlanRecipes', 'mealTypes'));
    }

    /**
     * Add a recipe to the meal planner
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Recipe $recipe)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $request->validate([
            'day' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Create or find meal plan for the selected day
        $mealPlan = MealPlan::firstOrCreate([
            'user_id' => $user->id,
            'day' => $request->day,
        ]);
        
        // Attach the recipe to the meal plan if not already attached
        if (!$mealPlan->recipes->contains($recipe->id)) {
            $mealPlan->recipes()->attach($recipe->id);
        }
        
        return redirect()->route('mealplanner.index')
            ->with('success', __('messages.success'));
    }

    /**
     * Remove a meal plan
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $mealPlan = MealPlan::findOrFail($id);
        
        // Check if the meal plan belongs to the authenticated user
        if ($mealPlan->user_id !== Auth::id()) {
            return redirect()->route('mealplanner.index')
                ->with('error', __('messages.error'));
        }
        
        // Detach all recipes and delete the meal plan
        $mealPlan->recipes()->detach();
        $mealPlan->delete();
        
        return redirect()->route('mealplanner.index')
            ->with('success', __('messages.success'));
    }

    /**
     * Generate a shopping list from the user's meal plans
     *
     * @return \Illuminate\Http\Response
     */
    public function shoppingList()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('messages.error'));
        }
        
        $user = Auth::user();
        $mealPlans = $user->mealPlans()->with('recipes.ingredients')->get();
        
        // Collect all ingredients from all recipes in the meal plans
        $ingredients = collect();
        foreach ($mealPlans as $mealPlan) {
            foreach ($mealPlan->recipes as $recipe) {
                $ingredients = $ingredients->concat($recipe->ingredients);
            }
        }
        
        // Group ingredients by name and sum quantities
        $groupedIngredients = $ingredients->groupBy('name')->map(function ($group) {
            return [
                'name' => $group->first()->name,
                'quantity' => $group->sum('pivot.quantity'),
                'unit' => $group->first()->pivot->unit
            ];
        });
        
        return view('mealplanner.shopping-list', compact('groupedIngredients'));
    }
}