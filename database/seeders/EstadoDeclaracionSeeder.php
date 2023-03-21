<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EstadoDeclaracionSeeder extends Seeder
{
    
    public function run()
    {
        $estados =[
            [
                'nombre_estado'=>'ASIGNACION CANAL DE AFORO',
                'cd_id'=>'4'
            ],
            [
                'nombre_estado'=>'CARGA NO EXPORTADA',
                'cd_id'=>'14'
            ],
            [
                'nombre_estado'=>'CERRADA',
                'cd_id'=>'9'
            ],
            [
                'nombre_estado'=>'DERIVACION AL AFORADOR',
                'cd_id'=>'5'
            ],
            [
                'nombre_estado'=>'LIQUIDADA',
                'cd_id'=>'3'
            ],
            [
                'nombre_estado'=>'OBSERVADA',
                'cd_id'=>'8'
            ],
            [
                'nombre_estado'=>'PRESCRIPCION',
                'cd_id'=>'12'
            ],
            [
                'nombre_estado'=>'PROCESO DE AFORO',
                'cd_id'=>'7'
            ],
            [
                'nombre_estado'=>'RECEPCION DECLARACION',
                'cd_id'=>'1'
            ],
            [
                'nombre_estado'=>'RECEPTADA',
                'cd_id'=>'6'
            ],
            [
                'nombre_estado'=>'RECHAZO',
                'cd_id'=>'11'
            ],
            [
                'nombre_estado'=>'REGULARIZADAA',
                'cd_id'=>'13'
            ],
            [
                'nombre_estado'=>'SALIDA AUTORIZADA',
                'cd_id'=>'10'
            ],
            [
                'nombre_estado'=>'VALIDACION',
                'cd_id'=>'2'
            ]
            
        ];
        DB::table('estado_declaracions')->insert($estados);
    }
}
