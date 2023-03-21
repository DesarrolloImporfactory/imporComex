<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ciudad>
 */
class CiudadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cod_provincia = [
            '1',
            '1',


        ];
        $cod_canton = [
            '1',
            '2',


        ];
        $nombre_provincia = [
            'AZUAY',
            'AZUAY',


        ];
        $nombre_canton = [
            'CUENCA',
            'GIRON',


        ];
        return [
            'cod_provincia' => $cod_provincia,
            'cod_canton' => $cod_canton,
            'nombre_provincia' => $nombre_provincia,
            'nombre_canton' => $nombre_canton
        ];
    }
}
