<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariablesSeeder extends Seeder
{
    
    public function run()
    {
        $tarifas=[
            [
                'nombre'=>'Tasa mensual naviera',
                'valor'=>'50',
                'minimo'=>'0'
            ],
            [
                'nombre'=>'baf',
                'valor'=>'105',
                'minimo'=>'0'
            ],
            [
                'nombre'=>'Aduana origen',
                'valor'=>'120',
                'minimo'=>'0'
            ],
            [
                'nombre'=>'Cargo logistico',
                'valor'=>'20',
                'minimo'=>'144'
            ],
            [
                'nombre'=>'Transmicion Ecuapass',
                'valor'=>'50',
                'minimo'=>'50'
            ],
            [
                'nombre'=>'Administracion',
                'valor'=>'50',
                'minimo'=>'50'
            ],
            [
                'nombre'=>'Cargo portuario',
                'valor'=>'10',
                'minimo'=>'50'
            ],
            [
                'nombre'=>'Agente aduana',
                'valor'=>'270',
                'minimo'=>'0'
            ],
        ];
        DB::table('variables')->insert($tarifas);
    }
}
