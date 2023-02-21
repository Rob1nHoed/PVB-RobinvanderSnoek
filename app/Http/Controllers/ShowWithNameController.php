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

        // De drink opzoeken in de database
        $drinks = Drink::where('name', 'like', '%' . $name . '%'); // Should be in scope?
        $drinksPerPage = 40; // Should be in a config file
        $totalResults = $drinks->count();
        $paginatedResults = $drinks->paginate($drinksPerPage, ['*'], 'page', $request->page);
        $totalPages = ceil($totalResults / $drinksPerPage);
        

        /** TODO
         *  Add this to a service, or at the other controller
         */

        if ($request->page < 1) {
            $request->page = 1;
        }

        var_dump($request->page);

        dd($paginatedResults);

        // De gebruiker met de data redirecten naar de zoekresultaten pagina
        return view('show.searchResult', [
            'drinks' => $paginatedResults,
            'count' => $totalResults,
            'page' => $request->page
        ]);
    }
}
