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
        return view('pantry.create');
    }

    public function store(Request $request)
    {
        Auth::user()->pantryItems()->create($request->only('name', 'quantity'));

        return redirect()->route('pantry.index')->with('success', 'Item added to pantry!');
    }

    public function edit(PantryItem $pantry)
    {
        $this->authorize('update', $pantry);
        return view('pantry.edit', compact('pantry'));
    }

    public function update(Request $request, PantryItem $pantry)
    {
        $this->authorize('update', $pantry);
        $pantry->update($request->only('name', 'quantity'));

        return redirect()->route('pantry.index')->with('success', 'Item updated!');
    }

    public function destroy(PantryItem $pantry)
    {
        $this->authorize('delete', $pantry);
        $pantry->delete();

        return redirect()->route('pantry.index')->with('success', 'Item deleted!');
    }
}
