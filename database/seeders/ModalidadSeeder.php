<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modalidades;
use Illuminate\Support\Facades\DB;

class ModalidadSeeder extends Seeder
{
    
    public function run()
    { 
        $modalidad =[
            [
                'modalidad'=>'FCL',
                'descripcion'=>'Contenedor completo '
            ],
            [
                'modalidad'=>'LCL',
                'descripcion'=>'Carga suelta'
            ],
            [
                'modalidad'=>'GRUPAL',
                'descripcion'=>'Carga grupal'
            ]
        ];
        DB::table('modalidades')->insert($modalidad);
    }
}
