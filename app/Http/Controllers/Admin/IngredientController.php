<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the ingredients.
     */
    public function index()
    {
        $ingredients = Ingredient::latest()->paginate(10);
        return view('admin.ingredients', compact('ingredients'));
    }

    /**
     * Show the form for creating a new ingredient.
     */
    public function create()
    {
        return view('admin.ingredients.create');
    }

    /**
     * Store a newly created ingredient in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients',
            'unit' => 'required|string|max:50',
        ]);

        Ingredient::create($request->all());

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingredient created successfully.');
    }

    /**
     * Show the form for editing the specified ingredient.
     */
    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    /**
     * Update the specified ingredient in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'unit' => 'required|string|max:50',
        ]);

        $ingredient->update($request->all());

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    /**
     * Remove the specified ingredient from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        // Check if ingredient is used in recipes
        if ($ingredient->recipes()->count() > 0) {
            return redirect()->route('admin.ingredients.index')
                ->with('error', 'Cannot delete ingredient used in recipes.');
        }

        // Check if ingredient is used in pantry
        if ($ingredient->pantryItems()->count() > 0) {
            return redirect()->route('admin.ingredients.index')
                ->with('error', 'Cannot delete ingredient used in pantry items.');
        }

        $ingredient->delete();

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Ingredient deleted successfully.');
    }
}