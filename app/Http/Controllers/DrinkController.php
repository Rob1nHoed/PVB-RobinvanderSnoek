<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drink;
use App\Models\Category;
use App\Models\Glass;

class DrinkController extends Controller
{
    public function index(int $id)
    {
        // Haal de drank op uit de database met de meegegeven id
        $drink = Drink::find($id);

        $ingredients = $drink->ingredients;

        // Haal de categorie op uit de database
        $category = Category::find($drink->category)->name;

        $alcohol= $drink->alcohol;

        // Haal de glas op uit de database met het id in de drink table
        $glass = Glass::find($drink->glass);
        
        // De measures van de ingredienten ophalen uit de pivot tabel
        $measures = [];
        foreach($ingredients as $ingredient){
            $measures[] = $ingredient->pivot->measure;
        }

        // De gebruiker met de data redirecten naar de view
        return view('show.drink', [
            'drink' => $drink,
            'ingredients' => $drink->ingredients,
            'measure' => $measures,
            'category' => $category,
            'alcohol' => $alcohol,
            'glass' => $glass,
        ]);
    }
}
