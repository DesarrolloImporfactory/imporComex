<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
    public function run()
    {

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
            'name'=>'Cristhian Talavera',
            'telefono'=>'0963607750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            //'email_verified_at'=>'2023-01-17 16:30:44',
            'email'=>'aduanas@imporcomexcorp.com',
            'password'=>md5('12345678'),
        ])->assignRole('Especialista');  

        User::create([
            'name'=>'Natalia Cruz',
            'telefono'=>'0963607750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            //'email_verified_at'=>'2023-01-17 16:30:44',
            'email'=>'n.cruz@imporcomexcorp.com',
            'password'=>md5('12345678'),
        ])->assignRole('Especialista');  
        User::create([
            'name'=>'Karen Condor',
            'telefono'=>'0963607750',
            'date'=>'01/05/1998',
            'importacion'=>'12',
            'idioma'=>'Ingles',
            'estado'=>'1',
            //'email_verified_at'=>'2023-01-17 16:30:44',
            'email'=>'k.condor@imporfactory.app',
            'password'=>md5('12345678'),
        ])->assignRole('Especialista');  

    }
}
