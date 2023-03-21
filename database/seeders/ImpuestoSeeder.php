<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImpuestoSeeder extends Seeder
{
    
    public function run()
    {
        $impuestos =[
            [
                'nombre'=>'IVA'
            ],
            [
                'nombre'=>'ADVALOREM'
            ],
            [
                'nombre'=>'OTROS'
            ]

        ];
        DB::table('impuestos')->insert($impuestos);
    }
}
