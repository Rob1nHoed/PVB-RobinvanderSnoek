<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Drink;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\Glass;
use App\Jobs\ProcessDrink;
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
    protected $description = 'Import drank and ingredient data from external API';

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

        // Ieder letter van het alfabet doorlopen en de dranken opvragen van de API
        foreach($letters as $letter)
        {

            $response = $client->get('https://www.thecocktaildb.com/api/json/v1/1/search.php?f=' . $letter);
            $letterData = $response->getBody()->getContents();
            $letterData = json_decode($letterData, true);
            
            // Als er geen dranken gevonden zijn voor de letter, dan de volgende letter proberen
            if(!empty($letterData['drinks'])) {
                $apiDrinksArray = array_merge($apiDrinksArray, $letterData['drinks']);
            }        
        }

        // Door alle dranken heen loopen
        foreach($apiDrinksArray as $drink)
        {
            // Check of de naam al in de database staat, zo ja, dan de volgende drank proberen
            if(Drink::where('name', $drink['strDrink'])->exists()) {
                continue;
            }
            
            // Als de drank niet in de database staat, dan de drank toevoegen aan de queue
            ProcessDrink::dispatch($drink)->onQueue('drinks');
        }
    }
}
