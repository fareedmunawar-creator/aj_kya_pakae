<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealPlanController extends Controller
{
    public function index()
    {
        $plans = Auth::user()->mealPlans()->with(['recipes' => function($query) {
            $query->with('media'); // Eager load media for recipe images
        }])->get();
        
        // Define days and meal types
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        // Get the active meal plan (most recent one)
        $activeMealPlan = $plans->sortByDesc('created_at')->first();
        
        // Organize recipes by day and meal type
        $organizedRecipes = [];
        
        if ($activeMealPlan) {
            foreach ($activeMealPlan->recipes as $recipe) {
                $pivot = $recipe->pivot;
                if (isset($pivot->day) && isset($pivot->meal_type)) {
                    if (!isset($organizedRecipes[$pivot->day])) {
                        $organizedRecipes[$pivot->day] = [];
                    }
                    if (!isset($organizedRecipes[$pivot->day][$pivot->meal_type])) {
                        $organizedRecipes[$pivot->day][$pivot->meal_type] = [];
                    }
                    $organizedRecipes[$pivot->day][$pivot->meal_type][] = $recipe;
                }
            }
        }
        
        // Pass $plans as $mealPlans to the view
        $mealPlans = $plans;
        
        return view('mealplanner.index', compact('organizedRecipes', 'days', 'mealTypes', 'activeMealPlan', 'mealPlans'));
    }

    public function create()
    {
        $days = [
            'monday' => __('Monday'),
            'tuesday' => __('Tuesday'),
            'wednesday' => __('Wednesday'),
            'thursday' => __('Thursday'),
            'friday' => __('Friday'),
            'saturday' => __('Saturday'),
            'sunday' => __('Sunday')
        ];
        
        $recipes = \App\Models\Recipe::all();
        
        return view('mealplanner.create', compact('days', 'recipes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'meals' => 'array'
        ]);
        
        $userId = Auth::id();
        $count = 0;
        
        // Create a single meal plan
        $mealPlan = new MealPlan();
        $mealPlan->user_id = $userId;
        $mealPlan->name = $request->name;
        $mealPlan->start_date = $request->start_date;
        $mealPlan->end_date = $request->end_date;
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
            
        return redirect()->route('mealplanner.index')->with('success', $message);
    }

    public function edit($id, Request $request)
    {
        $mealPlan = MealPlan::findOrFail($id);
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $day = $request->query('day');
        $mealType = $request->query('meal_type');
        
        $recipes = \App\Models\Recipe::all();
        $days = [
            'monday' => __('Monday'),
            'tuesday' => __('Tuesday'),
            'wednesday' => __('Wednesday'),
            'thursday' => __('Thursday'),
            'friday' => __('Friday'),
            'saturday' => __('Saturday'),
            'sunday' => __('Sunday')
        ];
        
        // Get current recipes for this meal plan
        $mealPlan->load(['recipes' => function($query) use ($day, $mealType) {
            if ($day && $mealType) {
                $query->wherePivot('day', $day)->wherePivot('meal_type', $mealType);
            }
        }]);
        
        $selectedRecipes = [];
        foreach ($mealPlan->recipes as $recipe) {
            $pivotDay = $recipe->pivot->day;
            $pivotMealType = $recipe->pivot->meal_type;
            $selectedRecipes[$pivotDay][$pivotMealType] = $recipe->id;
        }
        
        return view('mealplanner.edit', compact('mealPlan', 'recipes', 'days', 'selectedRecipes', 'day', 'mealType'));
    }

    public function update(Request $request, $id)
    {
        $mealPlan = MealPlan::findOrFail($id);
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'meals' => 'sometimes|array'
        ]);
        
        // Update meal plan details if provided
        if ($request->has('name')) {
            $mealPlan->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
        }
        
        // Update specific meal if provided
        if ($request->has('meals')) {
            foreach ($request->meals as $day => $mealTypes) {
                foreach ($mealTypes as $mealType => $recipeId) {
                    // Remove existing recipe for this day and meal type
                    $mealPlan->recipes()->wherePivot('day', $day)->wherePivot('meal_type', $mealType)->detach();
                    
                    // Add new recipe if selected
                    if (!empty($recipeId)) {
                        $mealPlan->recipes()->attach($recipeId, [
                            'day' => $day,
                            'meal_type' => $mealType
                        ]);
                    }
                }
            }
        }
        
        return redirect()->route('mealplanner.show', $mealPlan->id)->with('success', __('Meal plan updated successfully'));
    }
    
    public function remove($id)
    {
        $plan = Auth::user()->mealPlans()->findOrFail($id);
        $plan->recipes()->detach();
        $plan->delete();
        
        return redirect()->route('mealplanner.index')->with('success', 'Recipe removed from meal plan');
    }
    public function destroy(MealPlan $mealPlan)
    {
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $mealPlan->delete();

        return redirect()->route('mealplanner.index')->with('success', 'Meal plan deleted!');
    }

    public function generateShoppingList(MealPlan $mealPlan)
    {
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $mealPlan->load('recipes.ingredients');
        $ingredients = $mealPlan->recipes->flatMap->ingredients->groupBy('id');

        return view('mealplanner.shopping-list', compact('mealPlan', 'ingredients'));
    }
    
    public function show(MealPlan $mealPlan)
    {
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $mealPlan->load(['recipes' => function($query) {
            $query->with('category', 'media');
        }]);
        
        // Define days and meal types
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $mealTypes = ['breakfast', 'lunch', 'dinner', 'snack'];
        
        // Organize recipes by day and meal type
        $organizedRecipes = [];
        foreach ($mealPlan->recipes as $recipe) {
            $pivot = $recipe->pivot;
            if (isset($pivot->day) && isset($pivot->meal_type)) {
                $organizedRecipes[$pivot->day][$pivot->meal_type] = $recipe;
            }
        }
        
        return view('mealplanner.show', compact('mealPlan', 'organizedRecipes', 'days', 'mealTypes'));
    }
}
