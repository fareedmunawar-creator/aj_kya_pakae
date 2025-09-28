<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['user_id','category_id','title','description','image_path','cooking_time','servings','instructions','difficulty'];

    public function getStepsAttribute() {
        return $this->instructions ? explode("\n", $this->instructions) : [];
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function ingredients() {
        return $this->belongsToMany(Ingredient::class)->withPivot('quantity');
    }
    public function favorites() {
        return $this->belongsToMany(User::class, 'favorites', 'recipe_id', 'user_id');
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function mealPlans() {
        return $this->hasMany(MealPlan::class);
    }
    public function views() {
        return $this->hasMany(RecipeView::class);
    }
    
    public function media() {
        return $this->morphMany(Media::class, 'model');
    }
}
