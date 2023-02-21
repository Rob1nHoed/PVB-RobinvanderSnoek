<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // De categorie koppelen aan de dranken
    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }
}
