<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConvertToImperial
{
    public static function convertToImperial($measures): array
    {
        //check if the measure is a number
        foreach($measures as $key => $measure){

            // Bij mL, cL of L, convert naar oz
            if(strpos($measure, 'ml') !== false) {
                $measures = static::convertFromMetricUnits($measures, $measure, $key, ' ml', 0.033814);
            }

            else if(strpos($measure, 'cl') !== false) {
                $measures = static::convertFromMetricUnits($measures, $measure, $key, ' cl', 0.33814);
            }

            else if(strpos($measure, 'L') !== false) {
                $measures = static::convertFromMetricUnits($measures, $measure, $key, ' L', 33.814);
            }
        }

        return $measures;
    }

    public static function convertFromMetricUnits(array $measures, string $measure, int $key, string $unit, float $conversionFactor): array
    {
        $measures[$key] = str_replace($unit, '', $measure);
        $measures[$key] = (float)$measures[$key] * $conversionFactor;
        $measures[$key] = round($measures[$key], 2);

        // Als de measure dicht bij een rond getal zit, rond het dan af
        if($measures[$key] - round($measures[$key]) < 0.1){
            $measures[$key] = $measures[$key];
        }

        if($measures[$key] - round($measures[$key], 1) < 0.02){
            $measures[$key] = round($measures[$key], 1);
        }

        $measures[$key] = $measures[$key] . ' oz';

        return $measures;
    }
}