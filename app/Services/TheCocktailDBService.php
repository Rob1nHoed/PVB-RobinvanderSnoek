<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TheCocktailDBService
{
    public static function respondToRequest(string $url, bool $decodeFromJson): string|array
    {
        $client = new Client();
        $response = $client->request('GET', $url);
        $response = $response->getBody()->getContents();

        // Als $decodeFromJson true is, dan de response eerst decoden
        return $decodeFromJson 
            ? json_decode($response, true)
            : $response;

    }
}