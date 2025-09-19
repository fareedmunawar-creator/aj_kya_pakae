<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\PantryController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminController; 
use App\Http\Controllers\QuickCookController;
use App\Http\Controllers\Admin\AdminAnalyticsController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Recipes (full resource)
Route::resource('recipes', RecipeController::class);

// Pantry (CRUD)
Route::resource('pantry', PantryController::class);

// Meal Plans (CRUD)
Route::resource('meal-plans', MealPlanController::class);

// Meal Planner
Route::get('/mealplanner', [MealPlanController::class, 'index'])->name('mealplanner.index');
Route::post('/mealplanner/add/{recipe}', [MealPlanController::class, 'store'])->name('mealplanner.add');
Route::delete('/mealplanner/remove/{id}', [MealPlanController::class, 'remove'])->name('mealplanner.remove');

// Favorites (toggle only)
Route::post('/favorites/toggle/{recipe}', [FavoriteController::class, 'toggle'])
    ->name('favorites.toggle');

// Comments (store only)
Route::post('/comments', [CommentController::class, 'store'])
    ->name('comments.store');

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
            Route::get('/', [AdminAnalyticsController::class, 'dashboard'])->name('admin.dashboard');
        
        // Example: you can register more admin-only resources here
        Route::resource('recipes', RecipeController::class)->names('admin.recipes');
        Route::resource('pantry', PantryController::class)->names('admin.pantry');
        Route::resource('meal-plans', MealPlanController::class)->names('admin.meal-plans');
    });


    Route::post('/quick-cook', [QuickCookController::class, 'findRecipes'])->name('quick.cook');

    Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
        Route::get('/dashboard', [AdminAnalyticsController::class, 'dashboard'])->name('admin.dashboard');
    
        Route::get('/analytics/top-recipes', [AdminAnalyticsController::class, 'topRecipes']);
        Route::get('/analytics/ingredient-usage', [AdminAnalyticsController::class, 'ingredientUsage']);
        Route::get('/analytics/expiring-pantry', [AdminAnalyticsController::class, 'expiringPantry']);
        Route::get('/analytics/search-trends', [AdminAnalyticsController::class, 'searchTrends']);
        Route::get('/analytics/active-users', [AdminAnalyticsController::class, 'activeUsers']);
    });
// Language Switcher
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

require __DIR__.'/auth.php';
