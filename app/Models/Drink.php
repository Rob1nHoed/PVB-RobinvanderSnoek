<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'glass',
        'instructions',
        'image',
    ];

    // De drank koppelen aan ingredienten
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('measure');
    }

    // De drank koppelen aan categorieen
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    // De drank koppelen aan glazen
    public function glass()
    {
        return $this->belongsTo(Glass::class);
    }

    // Een scope maken om alleen featured dranken op te halen
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    // Een scope maken voor paginatie
    public function scopePaginate($query, $perPage = 10)
    {
        return $query->simplePaginate($perPage);
    }
}
