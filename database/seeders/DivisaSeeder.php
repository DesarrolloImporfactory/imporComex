<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisa;

class DivisaSeeder extends Seeder
{
   
    public function run()
    {
        Divisa::create([
            'tarifa'=>0.05
        ]);
    }
}
