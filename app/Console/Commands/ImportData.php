<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Drink;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\Glass;
use GuzzleHttp\Client;


class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cocktail and ingredient data from external API';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $client = new Client();

        // Alle letters van het alfabet in een array zetten 
        $letters = range('a', 'z');

        $apiDrinksArray = [];

        // Ieder letter van het alfabet doorlopen en de cocktails opvragen van de API
        foreach($letters as $key => $letter)
        {

            $response = $client->get('https://www.thecocktaildb.com/api/json/v1/1/search.php?f=' . $letter);
            $letterData = $response->getBody()->getContents();
            $letterData = json_decode($letterData, true);
            
            // Als er geen cocktails gevonden zijn voor de letter, dan de volgende letter proberen
            if(!empty($letterData['drinks'])) {
                $apiDrinksArray = array_merge($apiDrinksArray, $letterData['drinks']);
            }        
        }

        // Door alle cocktails heen loopen
        foreach($apiDrinksArray as $key => $drink)
        {
            // Check of de naam al in de database staat, zo ja, dan de volgende cocktail proberen
            if(Drink::where('name', $drink['strDrink'])->exists()) {
                continue;
            }
            
            // Als de cocktail niet in de database staat, dan de cocktail toevoegen aan de queue
            // wip
        }
    }
}
