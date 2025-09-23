<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPlan;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    /**
     * Display a listing of the meal plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mealPlans = MealPlan::with('user')->latest()->paginate(10);
        return view('admin.meal-plans.index', compact('mealPlans'));
    }

    /**
     * Show the form for creating a new meal plan.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $recipes = Recipe::all();
        return view('admin.meal-plans.create', compact('users', 'recipes'));
    }

    /**
     * Store a newly created meal plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $mealPlan = MealPlan::create($request->all());

        // Handle recipe assignments if provided
        if ($request->has('recipes')) {
            foreach ($request->recipes as $day => $meals) {
                foreach ($meals as $mealType => $recipeId) {
                    if ($recipeId) {
                        $mealPlan->recipes()->attach($recipeId, [
                            'day' => $day,
                            'meal_type' => $mealType
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.meal-plans.index')
            ->with('success', 'Meal plan created successfully.');
    }

    /**
     * Display the specified meal plan.
     *
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function show(MealPlan $mealPlan)
    {
        $mealPlan->load(['user', 'recipes']);
        return view('admin.meal-plans.show', compact('mealPlan'));
    }

    /**
     * Show the form for editing the specified meal plan.
     *
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(MealPlan $mealPlan)
    {
        $users = User::all();
        $recipes = Recipe::all();
        $mealPlan->load('recipes');
        
        // Organize assigned recipes by day and meal type
        $assignedRecipes = [];
        foreach ($mealPlan->recipes as $recipe) {
            $pivot = $recipe->pivot;
            $assignedRecipes[$pivot->day][$pivot->meal_type] = $recipe->id;
        }
        
        return view('admin.meal-plans.edit', compact('mealPlan', 'users', 'recipes', 'assignedRecipes'));
    }

    /**
     * Update the specified meal plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MealPlan $mealPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $mealPlan->update($request->all());
        
        // Clear existing recipe assignments
        $mealPlan->recipes()->detach();
        
        // Handle recipe assignments if provided
        if ($request->has('recipes')) {
            foreach ($request->recipes as $day => $meals) {
                foreach ($meals as $mealType => $recipeId) {
                    if ($recipeId) {
                        $mealPlan->recipes()->attach($recipeId, [
                            'day' => $day,
                            'meal_type' => $mealType
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.meal-plans.index')
            ->with('success', 'Meal plan updated successfully.');
    }

    /**
     * Remove the specified meal plan from storage.
     *
     * @param  \App\Models\MealPlan  $mealPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MealPlan $mealPlan)
    {
        // Delete associated recipe relationships
        $mealPlan->recipes()->detach();
        
        // Delete the meal plan
        $mealPlan->delete();

        return redirect()->route('admin.meal-plans.index')
            ->with('success', 'Meal plan deleted successfully.');
    }
}