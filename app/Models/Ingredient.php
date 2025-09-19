<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name','unit'];

    public function recipes() {
        return $this->belongsToMany(Recipe::class)->withPivot('quantity');
    }
    public function pantryItems() {
        return $this->hasMany(PantryItem::class);
    }
    public function substitutions() {
        return $this->hasMany(Substitution::class);
    }
}
