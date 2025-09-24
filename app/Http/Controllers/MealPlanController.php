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
        return view('mealplans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'recipe_id' => 'required|exists:recipes,id'
        ]);
        
        $mealPlan = new MealPlan();
        $mealPlan->user_id = Auth::id();
        $mealPlan->day = $request->day;
        $mealPlan->save();
        $mealPlan->recipes()->attach($request->recipe_id);

        return redirect()->route('mealplanner.index')->with('success', 'Recipe added to meal plan');
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
