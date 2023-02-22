<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drink;

class ShowWithIngredientsController extends Controller
{
    public function index()
    {
        // Alle geselecteerde ingredienten ophalen
        $ingredients = request('ingredients');

        // Als er geen ingredienten zijn geselecteerd, maak dan een lege collectie aan
        if(empty($ingredients)){
            $drinks = [];
        }
        else{
            // Haal alle dranken op die de geselecteerde ingredienten bevatten
            $drinks = Drink::with('ingredients')->whereHas('ingredients', function ($query) use ($ingredients) {
                $query->whereIn('id', $ingredients);
            })->get();
            
            // Door alle dranken heen loopen en kijken of ze ingredienten bevatten die niet zijn geselecteerd
            foreach ($drinks as $key => $drink) {
                // Door alle ingredienten van de drank heen loopen en kijken of ze in de geselecteerde ingredienten zitten
                foreach ($drink['ingredients'] as $ingredient) {
                    // Als ze niet in de geselecteerde ingredienten zitten, dan de drank uit de collectie halen
                    if (!in_array($ingredient['id'], $ingredients)) {
                        unset($drinks[$key]);
                        continue 2;
                    }
                }
            }
        }

        // De gebruiker met de data redirecten naar de zoekresultaten pagina
        return view('show.searchResult', [
            'drinks' => $drinks,
        ]);
    }
}
