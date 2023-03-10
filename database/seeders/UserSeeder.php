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
            'estado'=>'1',
            'email'=>'victor.robles@gmail.com',
            'password'=>md5('12345678'),
        ])->assignRole('Client');  

        User::create([
            'name'=>'Isaias Taipe',
            'telefono'=>'0984757750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            'email'=>'ariel.taipe2640@utc.edu.ec',
            'password'=>md5('12345678'),
        ])->assignRole('Alumno');  
        User::create([
            'name'=>'Daniel Bonilla',
            'telefono'=>'0984757750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            'email'=>'danielbonilla522@gmail.com',
            'password'=>md5('12345678'),
        ])->assignRole('Admin'); 

        User::create([
            'name'=>'Ariel Taipe',
            'telefono'=>'0963607750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            // 'email_verified_at'=>'2023-01-17 16:30:44',
            'email'=>'ariel.12isaias@gmail.com',
            'password'=>md5('12345678'),
        ])->assignRole('Admin');  

        User::create([
            'name'=>'Elizabeth',
            'telefono'=>'0963607750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            // 'email_verified_at'=>'2023-01-17 16:30:44',
            'email'=>'elizabeth.herrera@gmail.com',
            'password'=>md5('12345678'),
        ])->assignRole('Especialista');  
    }
}
