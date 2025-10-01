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

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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
Route::get('/mealplanner/create', [MealPlannerController::class, 'create'])->name('mealplanner.create');
Route::post('/mealplanner', [MealPlannerController::class, 'store'])->name('mealplanner.store');
Route::get('/mealplanner/shopping-list', [MealPlannerController::class, 'shoppingList'])->name('mealplanner.shopping-list');
Route::get('/mealplanner/{mealPlan}', [MealPlannerController::class, 'show'])->name('mealplanner.show');
Route::get('/mealplanner/{mealPlan}/edit', [MealPlannerController::class, 'edit'])->name('mealplanner.edit');
Route::put('/mealplanner/{mealPlan}', [MealPlannerController::class, 'update'])->name('mealplanner.update');
Route::delete('/mealplanner/{mealPlan}', [MealPlannerController::class, 'destroy'])->name('mealplanner.destroy');
Route::post('/mealplanner/add/{recipe}', [MealPlannerController::class, 'add'])->name('mealplanner.add');
Route::delete('/mealplanner/remove/{id}', [MealPlannerController::class, 'remove'])->name('mealplanner.remove');

// Favorites
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/toggle/{recipe}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::post('/recipes/{recipe}/favorite', [FavoriteController::class, 'store'])->name('recipes.favorite');
Route::delete('/recipes/{recipe}/favorite', [FavoriteController::class, 'destroy'])->name('recipes.favorite');

// Comments (store only)
Route::post('/comments/{recipe}', [CommentController::class, 'store'])
    ->name('comments.store');

// Quick Cook
Route::post('/quick-cook', [QuickCookController::class, 'findRecipes'])->name('quick.cook');
Route::get('/quick-cook', [QuickCookController::class, 'findRecipes'])->name('quick.cook.get');

// Admin routes
Route::prefix('admin')
->middleware(['auth', 'admin'])
->group(function () {
    Route::get('/', [AdminAnalyticsController::class, 'dashboard'])->name('admin.dashboard');
    
    // Admin resources - use Admin namespace controllers
    Route::resource('recipes', \App\Http\Controllers\Admin\RecipeController::class)->names('admin.recipes');
    Route::resource('pantry', \App\Http\Controllers\Admin\PantryController::class)->names('admin.pantry');
    Route::resource('meal-plans', \App\Http\Controllers\Admin\MealPlanController::class)->names('admin.meal-plans');
    
    // User management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    
    // Category management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    
    // Ingredient management
    Route::resource('ingredients', \App\Http\Controllers\Admin\IngredientController::class)->names('admin.ingredients');
    
    // Analytics views
    Route::view('/analytics/top-recipes', 'admin.analytics.top-recipes')->name('admin.analytics.top-recipes');
    Route::view('/analytics/ingredient-usage', 'admin.analytics.ingredient-usage')->name('admin.analytics.ingredient-usage');
    Route::view('/analytics/search-trends', 'admin.analytics.search-trends')->name('admin.analytics.search-trends');
    Route::view('/analytics/active-users', 'admin.analytics.active-users')->name('admin.analytics.active-users');
    
    // Analytics API endpoints
    Route::get('/analytics/data/top-recipes', [AdminAnalyticsController::class, 'topRecipes'])->name('admin.analytics.data.top-recipes');
    Route::get('/analytics/data/ingredient-usage', [AdminAnalyticsController::class, 'ingredientUsage'])->name('admin.analytics.data.ingredient-usage');
    Route::get('/analytics/data/expiring-pantry', [AdminAnalyticsController::class, 'expiringPantry'])->name('admin.analytics.data.expiring-pantry');
    Route::get('/analytics/data/search-trends', [AdminAnalyticsController::class, 'searchTrends'])->name('admin.analytics.data.search-trends');
    Route::get('/analytics/data/active-users', [AdminAnalyticsController::class, 'activeUsers'])->name('admin.analytics.data.active-users');
});

// API routes for admin analytics
Route::prefix('api/admin')
->middleware(['auth', 'admin'])
->group(function () {
    Route::get('/analytics/top-recipes', [AdminAnalyticsController::class, 'topRecipes']);
    Route::get('/analytics/ingredient-usage', [AdminAnalyticsController::class, 'ingredientUsage']);
    Route::get('/analytics/expiring-pantry', [AdminAnalyticsController::class, 'expiringPantry']);
    Route::get('/analytics/search-trends', [AdminAnalyticsController::class, 'searchTrends']);
    Route::get('/analytics/active-users', [AdminAnalyticsController::class, 'activeUsers']);
});
// Language Switcher
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// About Page
Route::view('/about', 'about')->name('about.index');

require __DIR__.'/auth.php';
