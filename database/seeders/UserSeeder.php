<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Victor',
            'telefono'=>'1',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'ingles',
            'email'=>'vistor.robles@gmail.com',
            'password'=>bcrypt('12345678'),
        ])->assignRole('Admin');  
    }
}
