<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        // Ensure we have a valid recipe
        if (!$recipe || !$recipe->id) {
            return back()->with('error', 'Invalid recipe.');
        }

        $recipe->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'recipe_id' => $recipe->id,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Comment added!');
    }
}
