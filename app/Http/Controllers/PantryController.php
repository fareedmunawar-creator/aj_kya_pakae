<?php

namespace App\Http\Controllers;

use App\Models\PantryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PantryController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $items = Auth::user()->pantryItems;
            return view('pantry.index', compact('items'));
        }
        
        return redirect()->route('login')->with('error', 'You must be logged in to view your pantry.');
    }

    public function create()
    {
        $ingredients = \App\Models\Ingredient::all();
        $units = ['g', 'kg', 'ml', 'l', 'cup', 'tbsp', 'tsp', 'piece', 'slice', 'bunch'];
        return view('pantry.create', compact('ingredients', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'expiry_date' => 'nullable|date'
        ]);
        
        Auth::user()->pantryItems()->create($validated);

        return redirect()->route('pantry.index')->with('success', 'Item added to pantry!');
    }

    public function edit(PantryItem $pantry)
    {
        // Check if the current user owns this pantry item
        if ($pantry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $ingredients = \App\Models\Ingredient::all();
        return view('pantry.edit', [
            'pantryItem' => $pantry,
            'ingredients' => $ingredients,
        ]);
    }

    public function update(Request $request, PantryItem $pantry)
    {
        // Check if the current user owns this pantry item
        if ($pantry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'expiry_date' => 'nullable|date'
        ]);
        
        $pantry->update($validated);

        return redirect()->route('pantry.index')->with('success', 'Item updated!');
    }

    public function destroy(PantryItem $pantry)
    {
        // Check if the current user owns this pantry item
        if ($pantry->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $pantry->delete();

        return redirect()->route('pantry.index')->with('success', 'Item deleted!');
    }
}
