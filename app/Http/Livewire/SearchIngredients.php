<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ingredient;

class SearchIngredients extends Component
{
    use WithPagination;

    public $ingredients = [];
    public $search = '';
    public $selected = [];
    public $pageNumber = 1;
    private $perPage = 40;

    // In het begin alle ingredienten ophalen en in de variabele $ingredients zetten
    public function mount($ingredients)
    {
        $this->ingredients = $ingredients;
        $this->perPage = config('pagination.perPage');
    }

    // Volgende pagina
    public function nextPage()
    {
        $this->pageNumber++;
    }

    // Vorige pagina
    public function previousPage()
    {
        $this->pageNumber--;
    }    
    
    public function addIngredient($ingredient)
    {
        // Als het ingredient nog niet in de geselecteerde ingredienten zit, voeg het dan toe
        if(!in_array($ingredient, $this->selected)){
            $this->selected[] = $ingredient;
        }
        // Als het ingredient al in de geselecteerde ingredienten zit, haal het dan uit de geselecteerde ingredienten
        else{
            $this->selected = array_diff($this->selected, [$ingredient]);
        }
    }

    // Wanneer de gebruiker op de zoekknop drukt, redirecten naar de controller met de geselecteerde ingredienten
    public function search()
    {
        return redirect()->route('show.searchResultFromIngredients', ['ingredients' => $this->selected]);
    }

    public function render()
    {
        // De view updaten met de ingredienten die overeenkomen met de zoekterm, met gebruik van de paginatie
        return view('livewire.search-ingredients', [
           'searchResults' => Ingredient::where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage, ['*'], 'page', $this->pageNumber),
        ]);
    }
}
