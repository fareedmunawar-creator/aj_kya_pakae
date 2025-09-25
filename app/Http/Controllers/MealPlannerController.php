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
        $mealPlans = $user->mealPlans()->with('recipes')->get();
        
        // Group meal plans by day for the weekly view
        $weeklyMealPlans = $mealPlans->groupBy('day');
        
        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
        
        // Get recipes for the create form
        $recipes = Recipe::all();
        
        return view('mealplanner.index', compact('weeklyMealPlans', 'mealPlans', 'days', 'recipes'));
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
        
        $mealPlan = MealPlan::with('recipes')->findOrFail($id);
        
        // Check if the meal plan belongs to the authenticated user
        if ($mealPlan->user_id !== Auth::id()) {
            return redirect()->route('mealplanner.index')
                ->with('error', __('messages.error'));
        }
        
        return view('mealplanner.show', compact('mealPlan'));
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
            'end_date' => 'required|date|after_or_equal:start_date',
            'meals' => 'array'
        ]);
        
        $userId = Auth::id();
        $count = 0;
        
        // Process each day and meal type
        if ($request->has('meals')) {
            foreach ($request->meals as $day => $mealTypes) {
                foreach ($mealTypes as $mealType => $recipeId) {
                    if (!empty($recipeId)) {
                        $mealPlan = new MealPlan();
                        $mealPlan->user_id = $userId;
                        $mealPlan->name = $request->name;
                        $mealPlan->day = $day;
                        $mealPlan->meal_type = $mealType;
                        $mealPlan->start_date = $request->start_date;
                        $mealPlan->end_date = $request->end_date;
                        $mealPlan->save();
                        
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
    
    public function edit($id)
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
        
        return view('mealplanner.edit', compact('mealPlan', 'days', 'recipes'));
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