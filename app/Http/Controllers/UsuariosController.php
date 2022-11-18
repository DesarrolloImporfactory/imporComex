<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    
    public function index()
    {
        $datos['usuarios']=User::get();
        return view('admin.usuarios.index',$datos);
    }

   
    public function create()
    {
        
    }

  
    public function store(Request $request)
    {
        $password1=$request->input('password');
        $datosUsuario= new User;
        $datosUsuario->name=$request->input('name');
        $datosUsuario->telefono=$request->input('telefono');
        $datosUsuario->date=$request->input('date');
        $datosUsuario->importacion=$request->input('importacion');
        $datosUsuario->idioma=$request->input('idioma');
        $datosUsuario->rol=$request->input('rol');
        $datosUsuario->estado=$request->input('estado');
        $datosUsuario->cedula=$request->input('cedula');
        $datosUsuario->ruc=$request->input('ruc');
        $datosUsuario->email=$request->input('email');
        $datosUsuario->password=Hash::make($password1);

        $datosUsuario->save();
        return redirect('usuarios')->with('mensaje','Usuario registrado');
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

 
    public function update(Request $request, $id)
    {
        
        $datos=array(
            "name"=>$request->input('name'),
            "telefono"=>$request->input('telefono'),
            "date"=>$request->input('date'),
            "importacion"=>$request->input('importacion'),
            "idioma"=>$request->input('idioma'),
            "rol"=>$request->input('rol'),
            "estado"=>$request->input('estado'),
            "cedula"=>$request->input('cedula'),
            "ruc"=>$request->input('ruc'),
            "email"=>$request->input('email'),
           " password"=>Hash::make($request->input('password'))
        );

        User::whereir($id)->update($datos);
        return redirect('usuarios')->with('mensajes','Usuario Actualizado');
    }

 
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('usuarios')->with('mensaje','Usuario Eliminado');
    }
}
