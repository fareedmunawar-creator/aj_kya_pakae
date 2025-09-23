<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('category', 'user')->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }
    
    public function toggle(Recipe $recipe)
    {
        $user = Auth::user();

        if ($user->favorites()->where('recipe_id', $recipe->id)->exists()) {
            $user->favorites()->detach($recipe->id);
            $message = 'Removed from favorites!';
        } else {
            $user->favorites()->attach($recipe->id);
            $message = 'Added to favorites!';
        }

        return back()->with('success', $message);
    }
}
