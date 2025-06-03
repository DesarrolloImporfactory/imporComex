<?php

namespace App\Models;

use GuzzleHttp\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function getCountries()
    {

        $filePath = public_path('json/paises.json'); // Ruta al archivo

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'El archivo JSON no existe'], 404);
        }

        $countries = json_decode(file_get_contents($filePath), true);

        $desiredCountries = ['Ecuador', 'Peru', 'Colombia'];
        $filteredCountries = [];

        foreach ($countries as $country) {
            if (in_array($country['name']['common'], $desiredCountries)) {
                $filteredCountries[] = $country;
            }
        }

        return $filteredCountries;
    }
}
