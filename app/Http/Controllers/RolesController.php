<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.roles.index')->only('index');
        // $this->middleware('can:admin.roles.store')->only('store');
        // $this->middleware('can:admin.roles.edit')->only('edit');
        // $this->middleware('can:admin.roles.destroy')->only('destroy');
    }

    public function index()
    {
        $roles= Role::get();
        $permissions= Permission::all();
        // $data=[
        //     'roles'=>$datos,
        //     'permisos'=>$datos1
        // ];
        return view('admin.roles.index',compact('roles','permissions'));
    }

  
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $role = Role::create($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.edit',$role)->with('mensaje','Rol creado');
        //return view('admin.roles.edit',$role)->with('mensaje','Rol creado');
    }

  
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions= Permission::all();

        return view('admin.roles.edit',compact('role','permissions'));
        
        
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required'
        ]);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        $permisos= Permission::all();
        $data=[
            'role'=>$role,
            'permisos'=>$permisos

        ];

        return redirect()->route('admin.roles.edit',$role)->with('mensaje','Rol actualizado');
    }

   
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('mensaje','Rol Eliminado');
    }
}
