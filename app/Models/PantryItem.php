<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PantryItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name','quantity','expiry_date'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function ingredient() {
        return $this->belongsTo(Ingredient::class);
    }
}
