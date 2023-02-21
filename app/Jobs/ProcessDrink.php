<?php

namespace App\Jobs;

use App\Jobs\ProcessCategory;
use App\Jobs\ProcessGlass;
use App\Jobs\ProcessIngredient;
use App\Models\Category;
use App\Models\Drink;
use App\Models\Glass; 
use App\Models\Ingredient;
use App\Services\ConvertToMetric;
use App\Services\TheCocktailDBService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessDrink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $drink;

    /**
     * Create a new job instance.
     *
     * @param array $drink
     * @return void
     */
    public function __construct($drink)
    {
        $this->drink = $drink;        
    }

    private $databaseIngredientsArray;
    private $databaseCategoriesArray;
    private $databaseGlassesArray;
    

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Alle namen van de ingrediënten, categorieën en glazen ophalen uit de database
        $this->databaseIngredientsArray = Ingredient::select('name')->get()->toArray();
        $this->databaseCategoriesArray = Category::select('name')->get()->toArray();
        $this->databaseGlassesArray = Glass::select('name')->get()->toArray();

        // Als de cocktail niet in de database staat, dan de cocktail opslaan
        $this->addNewDrink($this->drink);    
    }

    /**
     * Voegt een nieuwe categorie toe aan de database
     * 
     * @param string $categoryName
     * @return void
     */
    private function addNewDrink($drink): void
    {
        // Een nieuwe drink aanmaken vanaf de Drink model
        $newDrink = new Drink();
        $newDrink->name = $drink['strDrink'];
        $newDrink->instructions = $drink['strInstructions'];

        // De afbeelding van de cocktail opslaan in de public map
        $newDrink->image = $this->addImageData($drink);

        // Ingredienten toevoegen aan de cocktail
        $ingredients = $this->getCocktailIngredientsData($drink);

        // Measurments toevoegen aan de cocktail
        $measurements = $this->getIngredientMeasuresData($drink);

        // De categorie van de cocktail toevoegen
        $newDrink->category = $this->addCategoryData($drink['strCategory']);

        // Het glas waarin de cocktail wordt geserveerd toevoegen
        $newDrink->glass = $this->addGlassData($drink['strGlass']);
        
        // Toevoegen of de cocktail wel of geen alcohol bevat
        $newDrink->alcohol = $this->addAlcoholData($drink['strAlcoholic']);

        // Toevoegen of de cocktail featured is
        $newDrink->featured = $this->addFeaturedData();

        // De cocktail opslaan in de database
        $newDrink->save();

        // Door alle ingrediënten heen loopen, en deze toevoegen aan de cocktail
        foreach($ingredients as $key=>$ingredientName)
        {
            // Als het ingrediënt nog niet in de database staat, deze toevoegen aan de database
            if(!in_array($ingredientName, array_column($this->databaseIngredientsArray, 'name'))) {                   
                // Ingredient toevoegen aan de array met ingrediënten die al in de database staan, en hem toevoegen aan de database
                $this->databaseIngredientsArray = array_merge($this->databaseIngredientsArray, [$ingredientName]);
                $this->addNewIngredient($ingredientName, $measurements['strMeasure' . substr($key, -1)], $newDrink);      
                continue;
            }

            if(strpos($measurements['strMeasure' . substr($key, -1)], 'oz')) {
                $measurements['strMeasure' . substr($key, -1)] = ConvertToMetric::convertMeasurements($measurements['strMeasure' . substr($key, -1)]);
            }

            $newDrink->ingredients()->attach(Ingredient::where('name', $ingredientName)->first()->id, ['measure' => $measurements['strMeasure' . substr($key, -1)]]);
        }
    }

    /**
     * Alle ingrediënten van de cocktail ophalen 
     * 
     * @param array $drink
     * @return array
     */
    private function getCocktailIngredientsData(array $drink): array
    {
        // Alle ingrediënten van de drank ophalen
        $ingredients = array_filter($drink, function($key) {
            return strpos($key, 'strIngredient') !== false;
        }, ARRAY_FILTER_USE_KEY);

        // Alle lege ingrediënten verwijderen
        $ingredients = array_filter($ingredients);

        foreach($ingredients as $key=>$ingredient)
        {
            if(empty($ingredient)) {
                unset($ingredients[$key]);
            }
        }

        return $ingredients;
    }

    /**
     * Alle meetwaarden van de drank ophalen
     * 
     * @param array $drink
     * @return array
     */
    private function getIngredientMeasuresData(array $drink): array
    {
        // Alle meetwaarden van de ingrediënten opvragen
        return  array_filter($drink, function($key) {
            return strpos($key, 'strMeasure') !== false;
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * De categorie van de cocktail toevoegen
     * 
     * @param array $category
     * @return string
     */
    private function addCategoryData(string $category): string
    {
        // Als de categorie nog niet in de database staat, deze toevoegen aan de database
        if(!in_array($category, array_column($this->databaseCategoriesArray, 'name'))) {
            // Dispatchen van de ProcessCategory job
            ProcessCategory::dispatch($category)->onQueue('categories');

            // Het id tijdelijk de naam van de categorie geven
            $categoryId = $category;

            // Het toevoegen van de categorie aan de array met categorieën die al in de database staan
            $this->databaseCategoriesArray = array_merge($this->databaseCategoriesArray, [$category]);
        }
        else {
            // Het id opnemen van de categorie die al in de database staat
            $categoryId = Category::where('name', $category)->first()->id;
        }

        return $categoryId;
    }

    /**
     * Het glas waarin de drank wordt geserveerd toevoegen
     * 
     * @param string $glass
     * @return string
     */
    private function addGlassData(string $glass): string
    {
        // Als het glas nog niet in de database staat, deze toevoegen aan de database
        if(!in_array($glass, array_column($this->databaseGlassesArray, 'name'))) {
            // Dispatchen van de ProcessGlass job
            ProcessGlass::dispatch($glass)->onQueue('glasses');

            // Het id tijdelijk de naam van het glas geven
            $glassId = $glass;

            // Toevoegen aan de array met glazen die al in de database staan
            $this->databaseGlassesArray = array_merge($this->databaseGlassesArray, [$glass]);
        }
        else {
            // Het id opnemen van het glas dat al in de database staat
            $glassId = Glass::where('name', $glass)->first()->id;
        }

        return $glassId;
    }


    /**
     * Toevoegen of de drank wel of geen alcohol bevat
     * 
     * @param string $alcohol
     * @return bool
     */
    private function addAlcoholData(string $alcohol): bool
    {
        return $alcohol === 'Alcoholic'; 
    }


    /**
     * Toevoegen of de drank featured is, is random voor testdoeleinden
     * 
     * @return int
     */
    private function addFeaturedData(): int
    {
        return rand(1, 10) == 1 
            ? 1 
            : 0;
    }


    /**
     * De afbeelding van de drank opslaan in de public map
     * 
     * @param array $drink
     * @return string
     */
    private function addImageData(array $drink): string
    {
        // De URL en de naam van de afbeelding opslaan
        $url = $drink['strDrinkThumb'] . '/preview';
        $image = TheCocktailDBService::respondToRequest($url, false);

        // De extensie van de afbeelding opslaan
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($image);
        $extension = explode('/', $mime)[1];

        // De naam en url van de afbeelding opslaan
        $imageName = $drink['idDrink'] . '.' . $extension;
        $imagePath = 'images/drinks/' . $imageName;

        // De afbeelding van de drank opslaan in de public map
        Storage::disk('public')->put($imagePath, $image);

        return $imagePath;
    }


    /**
     * Een nieuw ingrediënt toevoegen aan de database
     * 
     * @param string $ingredientName
     * @param string|null $measurements
     * @param Drink $newDrink
     * @return void
     */
    private function addNewIngredient(string $ingredientName, string|null $measurements, Drink $newDrink): void
    {
        // Dispatchen van de ProcessIngredient job
        ProcessIngredient::dispatch($ingredientName, $measurements, $newDrink)->onQueue('ingredients');
    }
}
