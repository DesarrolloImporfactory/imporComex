<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdiomaSeeder extends Seeder
{
    
    public function run()
    {
        $idiomas =[
            [
                'nombre'=>'Español',
                'codigo'=>'es'
            ],
            [
                'nombre'=>'Ingles',
                'codigo'=>'in'
            ]

        ];
        DB::table('idiomas')->insert($idiomas);
    }
}
