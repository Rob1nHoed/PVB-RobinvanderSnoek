<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConvertToMetric
{
    public static function convertMeasurements($measurements): string
    {
        // 1/4, 1/2, 3/4 vervangen door decimale getallen
        $measurements = str_replace('1/4', '0.25', $measurements);
        $measurements = str_replace('1/2', '0.50', $measurements);
        $measurements = str_replace('3/4', '0.75', $measurements);
            
        // If:      Als er een spatie is, splits het in een array, want dan is er een decimaal getal en een kommagetal
        // Else:    Anders is het alleen een decimaal of alleen een kommagetal
        if(strpos($measurements, ' ')) {
            $measurements = explode(' ', $measurements);
            $measurements = ((float)$measurements[0] + (float)$measurements[1]) * 29.5735;
        }
        else {
            $measurements = $measurements * 29.5735;
        }

        // De measurements afronden op naar mL    
        return round($measurements) . ' ml';
    }
}