<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaccionSeeder extends Seeder
{
   
    public function run()
    {
        $data = [
            [
                'tipo_transaccion'=>'Factura',
                'signo'=>'1',
            ],
            [
                'tipo_transaccion'=>'Pago',
                'signo'=>'-1',
            ],
            [
                'tipo_transaccion'=>'Nota de credito',
                'signo'=>'1',
            ],
        ];

        DB::table('transaccions')->insert($data);
    }
}
