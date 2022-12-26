<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    
    public function run()
    {
        $estado = [
        'Libre',
        'Ocupado'
        ];

        foreach ($estado as $estados) {
            Estado::create([
                'name'=>$estados
            ]);
        }
    }
}
