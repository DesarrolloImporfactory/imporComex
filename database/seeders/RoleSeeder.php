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

        Permission::create(['name'=>'home','description'=>'Ver modulo de dashboard'])->syncRoles([$role,$role3]);

        Permission::create(['name'=>'admin.usuarios.index','description'=>'Ver modulo de usuarios'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.usuarios.edit','description'=>'Editar usuarios'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.usuarios.update','description'=>'Actualizar usuarios'])->syncRoles([$role]);
      

        Permission::create(['name'=>'admin.idiomas.index','description'=>'Ver modulo de idiomas'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.idiomas.store','description'=>'Crear idioma'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.idiomas.update','description'=>'Editar idioma'])->syncRoles([$role]);
        Permission::create(['name'=>'admin.idiomas.destroy','description'=>'Eliminar idioma'])->syncRoles([$role]);

        Permission::create(['name'=>'admin.paises.index','description'=>'Ver modulo de paises'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.paises.store','description'=>'Crear paises']);
        // Permission::create(['name'=>'admin.paises.update','description'=>'Editar paises']);
        // Permission::create(['name'=>'admin.paises.destroy','description'=>'Eliminar paises']);

        Permission::create(['name'=>'admin.cargas.index','description'=>'Ver modulo de cargas'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.cargas.store','description'=>'Crear cargas']);
        // Permission::create(['name'=>'admin.cargas.update','description'=>'Editar cargas']);
        // Permission::create(['name'=>'admin.cargas.destroy','description'=>'Eliminar cargas']);

        Permission::create(['name'=>'admin.modalidades.index','description'=>'Ver modulo de modalidades'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.modalidades.store','description'=>'Crear modalidades']);
        // Permission::create(['name'=>'admin.modalidades.update','description'=>'Editar modalidades']);
        // Permission::create(['name'=>'admin.modalidades.destroy','description'=>'Eliminar modalidades']);

        Permission::create(['name'=>'admin.roles.index','description'=>'Ver modulo de roles'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.roles.store','description'=>'Crear roles'])->syncRoles($role);
        // Permission::create(['name'=>'admin.roles.edit','description'=>'Editar roles'])->syncRoles($role);
        // Permission::create(['name'=>'admin.roles.destroy','description'=>'Eliminar roles'])->syncRoles($role);

        Permission::create(['name'=>'admin.calculadoras.index','description'=>'Calculadoras'])->syncRoles([$role, $role3,$role2]);
        
        // Permission::create(['name'=>'admin.colombia.create','description'=>'Ver cotizador'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.colombia.store','description'=>'Crear cotizacion'])->syncRoles([$role]);

        // Permission::create(['name'=>'validacion.print','description'=>'Ver PDFS'])->syncRoles([$role]);
        // Permission::create(['name'=>'validacion.store','description'=>'Crear proveedores'])->syncRoles([$role]);
      
        Permission::create(['name'=>'admin.contenedores.index','description'=>'Ver contenedores'])->syncRoles([$role, $role3]);
        // Permission::create(['name'=>'admin.contenedores.store','description'=>'Crear contenedores']);
        // Permission::create(['name'=>'admin.contenedores.edit','description'=>'Editar contenedores']);
        // Permission::create(['name'=>'admin.contenedores.destroy','description'=>'Eliminar contenedores']);

        // Permission::create(['name'=>'admin.estados.store','description'=>'Crear estados '])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.estados.edit','description'=>'Editar estados'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.estados.destroy','description'=>'Eliminar estados'])->syncRoles([$role]);

        Permission::create(['name'=>'admin.cotizaciones.show','description'=>'Ver cotizaciones'])->syncRoles([$role, $role3,$role2]);
        // Permission::create(['name'=>'admin.cotizaciones.destroy','description'=>'Eliminar cotizaciones'])->syncRoles([$role]);

        Permission::create(['name'=>'admin.especialistas.show','description'=>'Dashboar Especialistas'])->syncRoles([$role, $role3]);
        // Permission::create(['name'=>'admin.especialistas.edit','description'=>'Editar cotizacion'])->syncRoles([$role]);
        // Permission::create(['name'=>'admin.especialistas.update','description'=>'Actualizar cotizacion'])->syncRoles([$role]);


        
    }
}
