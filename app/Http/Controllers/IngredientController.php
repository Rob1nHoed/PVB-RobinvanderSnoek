<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index($id)
    {
        // Haal het ingredient op uit de database
        $ingredient = Ingredient::find($id);

        // De gebruiker met de data redirecten naar de ingredient pagina
        return view('show.ingredient', [
            'ingredient' => $ingredient,
        ]);
    }
}
