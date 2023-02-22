<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ViewNavigation extends Component
{
    public $open = false;

    // Navigatie openen / sluiten
    public function toggle()
    {
        $this->open = !$this->open;
    }   

    public function render()
    {
        return view('livewire.view-navigation');
    }
}