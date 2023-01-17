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
            'telefono'=>'0963657780',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'email'=>'victor.robles@gmail.com',
            'password'=>bcrypt('12345678'),
        ])->assignRole('Client');  

        User::create([
            'name'=>'Pedro',
            'telefono'=>'0984757750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'email'=>'pedro.trujillo@gmail.com',
            'password'=>bcrypt('12345678'),
        ])->assignRole('Especialista');  
        User::create([
            'name'=>'Daniel Bonilla',
            'telefono'=>'0984757750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'email'=>'danielbonilla522@gmail.com',
            'password'=>bcrypt('12345678'),
        ])->assignRole('Admin'); 

        User::create([
            'name'=>'Ariel Taipe',
            'telefono'=>'0963607750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            // 'email_verified_at'=>'2023-01-17 16:30:44',
            'email'=>'ariel.12isaias@gmail.com',
            'password'=>bcrypt('12345678'),
        ])->assignRole('Admin');  
    }
}
