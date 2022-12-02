<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contenedores;

class ContenedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carga =[
            '20 FT DRY',
            '40 FT DRY',
            '40 FT HQ'

        ];
        foreach ($carga as $cargas) {
            Contenedores::create([
                'name'=>$cargas
            ]);
        }
    }
}
