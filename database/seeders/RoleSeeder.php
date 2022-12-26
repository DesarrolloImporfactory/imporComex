<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role=Role::create(['name'=>'Admin']);
        $role2=Role::create(['name'=>'Client']);
        $role3=Role::create(['name'=>'Especialista']);

        Permission::create(['name'=>'home','description'=>'Ver modulo de dashboard'])->syncRoles([$role,$role2]);

        Permission::create(['name'=>'admin.usuarios.index','description'=>'Ver modulo de usuarios'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.usuarios.edit','description'=>'Editar usuarios'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.usuarios.update','description'=>'Actualizar usuarios'])->syncRoles([$role]);
      

        Permission::create(['name'=>'admin.idiomas.index','description'=>'Ver modulo de idiomas'])->syncRoles([$role,$role2]);
        Permission::create(['name'=>'admin.idiomas.store','description'=>'Crear idioma'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.idiomas.update','description'=>'Editar idioma'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.idiomas.destroy','description'=>'Eliminar idioma'])->syncRoles([$role]);
    }
}
