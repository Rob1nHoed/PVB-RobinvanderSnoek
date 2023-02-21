<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    // De ingredient koppelen aan de dranken
    public function drinks()
    {
        return $this->belongsToMany(Drink::class)->withPivot('measure');
    }

    // Een scope maken om alle ingredienten op te halen
    public function scopeAllIngredients()
    {
        $allIngredients = Ingredient::all();
        return $allIngredients;
    }
}
