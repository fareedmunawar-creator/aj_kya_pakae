<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'day', 'planned_date', 'name', 'start_date', 'end_date', 'meal_type'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'planned_date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function recipes() {
        return $this->belongsToMany(Recipe::class)->withPivot('day', 'meal_type');
    }
}
