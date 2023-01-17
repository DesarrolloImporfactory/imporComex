<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idioma;
use App\Models\Paises;
use App\Models\Modalidades;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades;

class UsuariosController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.usuarios.index')->only('index');
        $this->middleware('can:admin.usuarios.edit')->only('edit','update');
       
       }
    
    public function index()
    {
        $usuario=User::get();
        $idioma=Idioma::get();
        $datos=[
            'usuarios'=>$usuario,
            'idiomas'=>$idioma
        ];

        return view('admin.usuarios.index',$datos);
    }

    public function createUserFast(Request $request){

        $idModalidad = $request->input('modalidad');
        $modalidad = Modalidades::findOrFail($idModalidad);
        $idPais = $request->input('paises');
        $pais = Paises::findOrFail($idPais);
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();

        $mensajes = [
            'modalidad' => $modalidad,
            'paises' => $pais,
            'clientes'=>$clientes

        ];
        $request->validate([
            'nombre'=>['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
               
         ]);
        User::create([
            'name'=>$request->input('nombre'),
            'telefono'=>$request->input('telefono'),
            'ruc'=>$request->input('ruc'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password')),
        ])->assignRole('Client'); 

        return view('admin.calculadoras.colombia.grupal.create', $mensajes);
    }

   
    public function create()
    {
        $roles=Role::get();
        $usuario=User::get();
        $idioma=Idioma::get();
        $datos=[
            'roles'=>$roles,
            'usuarios'=>$usuario,
            'idiomas'=>$idioma
        ];
         return view('admin.usuarios.formCreate',$datos);
    }

  
    public function store(Request $request)
    {

        $request->validate([
            'name'=>['required'],
            'idioma' => ['required'],
            'telefono' => ['required'],
            'date'=>['required'],
            'importacion' => ['required'],
            'ruc'=>['required'],
            'cedula' => ['required','min:9','max:10'],
            'email' => ['required','email'],
            'password' => ['required'],
            'roles'=>['required'],
               
         ]);

        $estado = $request->input('estado');
        $password1=$request->input('password');
        User::create([
            'name'=>$request->input('name'),
            'telefono'=>$request->input('telefono'),
            'date'=>$request->input('date'),
            'importacion'=>$request->input('importacion'),
            'idioma'=>$request->input('idioma'),
            'cedula'=>$request->input('cedula'),
            'ruc'=>$request->input('ruc'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($password1),
        ])->assignRole($request->input('roles')); 
        
        return redirect('admin/usuarios')->with('mensaje','Usuario registrado');
    }
   
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $rol = Role::all();
        $idiomas=Idioma::get();
        return view('admin.usuarios.formEdit',compact('user','rol','idiomas'));
    }
    //asignar roles al usuario
    public function show(Request $request, $user)
    {
    
    }

 
    public function update(Request $request, $user)
    {
        $request->validate([
            'name'=>['required'],
            'idioma' => ['required'],
            'telefono' => ['required'],
            'date'=>['required'],
            'importacion' => ['required'],
            'estado' => ['required'],
            'ruc'=>['required'],
            'cedula' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'roles'=>['required'],
               
         ]);
        $users=User::findOrFail($user);
        $datos=array(
            'name'=>$request->input('name'),
            'telefono'=>$request->input('telefono'),
            'date'=>$request->input('date'),
            'importacion'=>$request->input('importacion'),
            'idioma'=>$request->input('idioma'),
            'estado'=>$request->input('estado'),
            'cedula'=>$request->input('cedula'),
            'ruc'=>$request->input('ruc'),
            'email'=>$request->input('email'),
        );
        User::whereid($user)->update($datos);
        $users->roles()->sync($request->roles);
        //User::whereid($user)->update($datos);
        return redirect('admin/usuarios')->with('mensaje','Roles Asignados');
    }

 
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('usuarios')->with('mensaje','Usuario Eliminado');
    }
}
