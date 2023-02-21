<?php

namespace App\Jobs;

use App\Models\Ingredient;
use App\Services\TheCocktailDBService;
use App\Services\ConvertToMetric;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessIngredient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ingredientName;
    private $measurements;
    private $newDrink;


    /**
     * Create a new job instance.
     *
     * @param string $ingredientName
     * @param string $measurements
     * @param int $newDrink
     * @return void
     */
    public function __construct($ingredientName, $measurements, $newDrink)
    {
        $this->ingredientName = $ingredientName;
        $this->measurements = $measurements;
        $this->newDrink = $newDrink;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ingredientName = $this->ingredientName;
        $measurements = $this->measurements;
        $newDrink = $this->newDrink;

        // Als het ingredient al bestaat in de database, attachen aan de drink
        if(Ingredient::where('name', $ingredientName)->exists()){
            $ingredient = Ingredient::where('name', $ingredientName)->first();

            $measurements = $this->AddMeasurementsForIngredient($measurements);
            $ingredient->drinks()->attach($this->newDrink, ['measure' => $measurements]);

            return;
        }

        // Het ingredient ophalen uit de API
        $url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?i=" . $ingredientName;
        $ingredientData = TheCocktailDBService::respondToRequest($url, true);
        
        // Een nieuw ingrediënt aanmaken vanaf de Ingredient model
        $newIngredient = new Ingredient();
        $newIngredient->name = $ingredientName;
        $newIngredient->description = $ingredientData['ingredients'][0]['strDescription'];
        $newIngredient->type = $ingredientData['ingredients'][0]['strType'];

        // De alcohol boolean data toevoegen aan het ingredient
        $newIngredient->alcohol = $this->AddAlcohol($ingredientData['ingredients'][0]['strAlcohol']);

        // De afbeelding van het ingrediënt opslaan in de public map en de url opslaan in de database
        $newIngredient->image = $this->AddImage($ingredientName);

        // Het ingredient opslaan in de database
        $newIngredient->save();

        // De measurements opnemen
        $measurements = $this->AddMeasurementsForIngredient($measurements);

        // Koppel het ingredient aan de drink
        $newIngredient->drinks()->attach($newDrink->id, ['measure' => $measurements]);

        // De alcohol boolean data toevoegen aan de cocktail
        if($newIngredient->alcohol == 1) {
            $newDrink->alcohol = 1;
            $newDrink->save();
        }
    }


    /**
     * De afbeelding van het ingrediënt opslaan in de public map en de url opslaan in de database
     *
     * @param string $ingredientName
     * @return string
     */
    private function addImage(string $ingredientName): string
    {
        // De afbeelding van het ingrediënt ophalen uit de API
        $url = "https://www.thecocktaildb.com/images/ingredients/" . $ingredientName . "-Medium.png";
        $image = TheCocktailDBService::respondToRequest($url, false);
        
        // De extensie van de afbeelding bepalen
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($image);
        $extension = explode('/', $mime)[1];

        // De naam en url van de afbeelding bepalen
        $imageName = $ingredientName . '.' . $extension;        
        $imagePath = 'images/ingredients/' . $imageName;

        // De afbeelding opslaan in de public map
        Storage::disk('public')->put($imagePath, $image);

        return $imagePath;
    }


    /**
     * De alcohol boolean data toevoegen aan het ingredient
     *
     * @param string $alcohol
     * @return bool
     */
    private function addAlcohol(string $alcohol): bool
    {
        return $alcohol === 'Yes'; 
    }


    /**
     * Als de measurements in oz staan, omzetten naar ml
     *
     * @param string|null $measurements
     * @return string|null
     */
    private function AddMeasurementsForIngredient(string|null $measurements): string|null
    {  
        return strpos($measurements, 'oz') 
            ? ConvertToMetric::convertMeasurements($measurements) 
            : $measurements;
    }
}