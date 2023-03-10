<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drink;

class ShowWithNameController extends Controller
{
    public function index(Request $request)
    {
        // De naam van de drink uit de request halen
        $name = $request->name;

        $drinks = Drink::like($name)->get();

        // De gebruiker met de data redirecten naar de zoekresultaten pagina
        return view('show.searchResult', [
            'drinks' => $drinks,
        ]);
    }
}
