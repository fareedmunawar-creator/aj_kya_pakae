<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'unit'];
    
    /**
     * Get the recipes that use this ingredient.
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'ingredient_recipe')
            ->withPivot('quantity', 'unit')
            ->withTimestamps();
    }
    
    /**
     * Get the pantry items for this ingredient.
     */
    public function pantryItems()
    {
        return $this->hasMany(PantryItem::class);
    }
    
    /**
     * Get the substitutions for this ingredient.
     */
    public function substitutions()
    {
        return $this->hasMany(Substitution::class);
    }
}
