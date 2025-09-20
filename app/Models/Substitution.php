<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Substitution extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient_id','substitute_id','note'];

    public function ingredient() {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }
    public function substitute() {
        return $this->belongsTo(Ingredient::class, 'substitute_id');
    }
}
