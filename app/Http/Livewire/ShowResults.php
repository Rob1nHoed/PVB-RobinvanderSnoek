<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Drink;
use Illuminate\Pagination\Paginator;

class ShowResults extends Component
{
    use WithPagination;

    public $pageNumber = 1;  
    public $drinks = [];  
    public $perPage = 20; // Standaard aantal resultaten per pagina

    // In het begin alle ingredienten ophalen en in de variabele $ingredients zetten
    public function mount($drinks)
    {
        $this->drinks = $drinks;
        $this->perPage = config('pagination.perPage');
    }

    // Volgende pagina
    public function nextResultPage()
    {
        $this->pageNumber++;
    }

    // Vorige pagina
    public function previousResultPage()
    {
        $this->pageNumber--;
    }    

    public function render()
    {
        // De view updaten met de ingredienten die overeenkomen met de zoekterm, met gebruik van de paginatie
        return view('livewire.show-results', [
            'paginatedDrinks' => $this->drinks->forPage($this->pageNumber, $this->perPage),
        ]);
    }
}
