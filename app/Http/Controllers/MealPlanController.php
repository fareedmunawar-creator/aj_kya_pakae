<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealPlanController extends Controller
{
    public function index()
    {
        $plans = Auth::user()->mealPlans()->with('recipes')->get();
        
        $mealPlans = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => []
        ];
        
        foreach ($plans as $plan) {
            if (isset($plan->day)) {
                $mealPlans[strtolower($plan->day)][] = $plan;
            }
        }
        
        return view('mealplanner.index', compact('mealPlans'));
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

    public function edit(MealPlan $mealPlan)
    {
        $this->authorize('update', $mealPlan);
        return view('mealplans.edit', compact('mealPlan'));
    }

    public function update(Request $request, MealPlan $mealPlan)
    {
        $this->authorize('update', $mealPlan);
        $mealPlan->update($request->only('day'));

        if ($request->has('recipes')) {
            $mealPlan->recipes()->sync($request->recipes);
        }

        return redirect()->route('mealplanner.index')->with('success', 'Meal plan updated!');
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
        $this->authorize('delete', $mealPlan);
        $mealPlan->delete();

        return redirect()->route('mealplans.index')->with('success', 'Meal plan deleted!');
    }

    public function generateShoppingList(MealPlan $mealPlan)
    {
        $mealPlan->load('recipes.ingredients');
        $ingredients = $mealPlan->recipes->flatMap->ingredients->groupBy('id');

        return view('mealplans.shopping-list', compact('mealPlan', 'ingredients'));
    }
}
