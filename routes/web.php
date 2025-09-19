<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\PantryController;
use App\Http\Controllers\MealPlannerController;
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
Route::resource('meal-plans', MealPlannerController::class);

// Meal Planner
Route::get('/mealplanner', [MealPlannerController::class, 'index'])->name('mealplanner.index');
Route::post('/mealplanner/add/{recipe}', [MealPlannerController::class, 'add'])->name('mealplanner.add');
Route::delete('/mealplanner/remove/{id}', [MealPlannerController::class, 'remove'])->name('mealplanner.remove');

// Favorites (toggle only)
Route::post('/favorites/toggle/{recipe}', [FavoriteController::class, 'toggle'])
    ->name('favorites.toggle');

// Comments (store only)
Route::post('/comments', [CommentController::class, 'store'])
    ->name('comments.store');

// Quick Cook
Route::post('/quick-cook', [QuickCookController::class, 'findRecipes'])->name('quick.cook');

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/', [AdminAnalyticsController::class, 'dashboard'])->name('admin.dashboard');
        
        // Admin resources
        Route::resource('recipes', RecipeController::class)->names('admin.recipes');
        Route::resource('pantry', PantryController::class)->names('admin.pantry');
        Route::resource('meal-plans', MealPlannerController::class)->names('admin.meal-plans');
        
        // User management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
        
        // Category management
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
        
        // Ingredient management
        Route::resource('ingredients', \App\Http\Controllers\Admin\IngredientController::class)->names('admin.ingredients');
        
        // Analytics routes
        Route::get('/analytics/top-recipes', [AdminAnalyticsController::class, 'topRecipes'])->name('admin.analytics.top-recipes');
        Route::get('/analytics/ingredient-usage', [AdminAnalyticsController::class, 'ingredientUsage'])->name('admin.analytics.ingredient-usage');
        Route::get('/analytics/expiring-pantry', [AdminAnalyticsController::class, 'expiringPantry'])->name('admin.analytics.expiring-pantry');
        Route::get('/analytics/search-trends', [AdminAnalyticsController::class, 'searchTrends'])->name('admin.analytics.search-trends');
        Route::get('/analytics/active-users', [AdminAnalyticsController::class, 'activeUsers'])->name('admin.analytics.active-users');
    });
// Language Switcher
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

require __DIR__.'/auth.php';
