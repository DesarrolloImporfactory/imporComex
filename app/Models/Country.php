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
    $client = new Client();

    $response = $client->get("https://restcountries.com/v3.1/all");
    $countries = json_decode($response->getBody(), true);

    $desiredCountries = ['Ecuador', 'Peru'];
    $filteredCountries = [];

    foreach ($countries as $country) {
        if (in_array($country['name']['common'], $desiredCountries)) {
            $filteredCountries[] = $country;
        }
    }

    return $filteredCountries;
}

}
