<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifaSeeder extends Seeder
{
    
    public function run()
    {
        $tarifas=[
            [
                'm3'=>'0.5',
                'vxcbm'=>'700.00',
                'tcbm'=>'350'
            ],
            [
                'm3'=>'1',
                'vxcbm'=>'550.00',
                'tcbm'=>'550'
            ],
            [
                'm3'=>'2',
                'vxcbm'=>'500.00',
                'tcbm'=>'1000'
            ],
            [
                'm3'=>'3',
                'vxcbm'=>'425.00',
                'tcbm'=>'1275'
            ],
            [
                'm3'=>'4',
                'vxcbm'=>'355.00',
                'tcbm'=>'1420'
            ],
            [
                'm3'=>'5',
                'vxcbm'=>'250.00',
                'tcbm'=>'1250'
            ],
            [
                'm3'=>'6',
                'vxcbm'=>'250.00',
                'tcbm'=>'1500'
            ],
            [
                'm3'=>'7',
                'vxcbm'=>'250.00',
                'tcbm'=>'1750'
            ],
            [
                'm3'=>'8',
                'vxcbm'=>'250.00',
                'tcbm'=>'2000'
            ],
            [
                'm3'=>'9',
                'vxcbm'=>'250.00',
                'tcbm'=>'2250'
            ],
            [
                'm3'=>'10',
                'vxcbm'=>'250.00',
                'tcbm'=>'2500'
            ],
            [
                'm3'=>'11',
                'vxcbm'=>'250.00',
                'tcbm'=>'2750'
            ],
            [
                'm3'=>'12',
                'vxcbm'=>'250.00',
                'tcbm'=>'3000'
            ],
            [
                'm3'=>'13',
                'vxcbm'=>'225.00',
                'tcbm'=>'2925'
            ],
            [
                'm3'=>'14',
                'vxcbm'=>'225.00',
                'tcbm'=>'3150'
            ],
            [
                'm3'=>'15',
                'vxcbm'=>'225.00',
                'tcbm'=>'3375'
            ]
            
        ];
        DB::table('tarifa_gruapls')->insert($tarifas);
    }
}
