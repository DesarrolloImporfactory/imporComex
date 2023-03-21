<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FormaPago;

class PagoSeeder extends Seeder
{

    public function run()
    {
        $estado = [
            'Tarjeta Credito',
            'Debito',
            'Transferencia'
        ];

        foreach ($estado as $estados) {
            FormaPago::create([
                'tipo_pago' => $estados
            ]);
        }
    }
}
