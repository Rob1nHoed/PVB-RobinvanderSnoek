<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\ConvertToImperial;

class SwapMeasureType extends Component
{
    public $measureType = 'metric';

    public $measure;
    public $metric;
    public $ingredients;

    // De measures die worden meegegeven aan de livewire component
    public function mount($measure)
    {
        $this->measures = $measure;
        $this->metric = $measure;
    }

    public function swapMeasureType()
    {
        // If: Als de measureType gelijk is aan imperial, dan resetten we de measures naar de originele measures
        // Else: Als de measureType gelijk is aan metric, dan converteren we de measures naar imperial
        if($this->measureType == 'imperial'){
             $this->resetToMetric();
        }else{
            $this->convertToImperial($this->measures);
        }
    }

    private function convertToImperial($measures)
    {
        $this->measureType = 'imperial';
            
        // De measures veranderen naar Imperial measures
        $this->measures = ConvertToImperial::convertToImperial($measures);
    }

    public function resetToMetric()
    {
        // De measures resetten naar de originele measures i.p.v weer converten, scheelt een hoop rekenwerk
        $this->measureType = 'metric';
        $this->measures = $this->metric;
    }

    public function render()
    {
        // View renderen met nieuwe measure type
        return view('livewire.swap-measure-type', [
            'measures' => $this->measures,
        ]);
    }
}