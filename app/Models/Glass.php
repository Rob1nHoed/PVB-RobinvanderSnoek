<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Het glas koppelen aan de dranken
    public function drinks()
    {
        return $this->belongsToMany(Drink::class);
    }

}
