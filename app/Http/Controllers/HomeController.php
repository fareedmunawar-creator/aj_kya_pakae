<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class HomeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        // Hero section data could be static or from DB
        $hero = [
            'title' => 'Aj Kya Pakae?',
            'subtitle' => 'Find the best recipes for today!',
        ];

        // Trending recipes = top by favorites or ratings
        $trending = Recipe::withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(6)
            ->get();

        return view('home', compact('hero', 'trending', 'recipes'));
    }
}
