<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeView extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id','user_id','ip_address'];

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
