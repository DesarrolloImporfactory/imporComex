<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contenedores;
use Illuminate\Support\Facades\DB;

class ContenedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contenedores =[
            [
                'name'=>'20 FT DRY',
                'estado_id'=>'1'
            ],
            [
                'name'=>'40 FT DRY',
                'estado_id'=>'1'
            ],
            [
                'name'=>'40 FT HQ',
                'estado_id'=>'1'
            ]

        ];
        DB::table('contenedores')->insert($contenedores);
        
    }
}
