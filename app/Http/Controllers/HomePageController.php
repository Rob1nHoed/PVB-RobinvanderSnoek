<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drink;

class HomePageController extends Controller
{
    public function index()
    {
        // Haal 8 willekeurige dranken op uit de database die featured zijn
        $featured = Drink::inRandomOrder()
            ->featured()
            ->limit(8)
            ->get();

        // Haal 8 willekeurige dranken op uit de database
        $random = Drink::inRandomOrder()
            ->limit(8)
            ->get();

        // De gebruiker met de data redirecten naar de homepage
        return view('homepage', [
            'featured' => $featured,
            'random' => $random,
        ]);
    }
}
