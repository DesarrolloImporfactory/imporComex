<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incoterm;

class IncotermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carga =[
            'EXW',
            'FCA',
            'FAS',
            'FOB',
            'CPT',
            'CFR',
            'CIF', 
            'CIP',
            'DAT',
            'DAP',
            'DDP'

        ];
        foreach ($carga as $cargas) {
            Incoterm::create([
                'name'=>$cargas
            ]);
        }
    }
}
