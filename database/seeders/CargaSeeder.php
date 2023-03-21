<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\tipo_cargas;

class CargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carga =[
            'GENERAL',
            'PELIGROSA',
            'SOBRE DIMENSIONADA'
        ];
        foreach ($carga as $cargas) {
            tipo_cargas::create([
                'tipoCarga'=>$cargas
            ]);
        }
    }
}
