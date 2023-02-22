<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class SearchWithIngredientsController extends Controller
{
    public function index()
    {
        // Haal alle ingredienten op uit de database
        $ingredients = Ingredient::allIngredients();

        // De gebruiker met de data redirecten naar de zoekpagina met ingredienten
        return view('search.withIngredients', [
            'ingredients' => $ingredients,
        ]);
    }
}
