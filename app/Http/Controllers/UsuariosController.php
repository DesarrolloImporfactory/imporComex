<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idioma;
use App\Models\Paises;
use App\Models\Modalidades;
use App\Notifications\SendPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ChangPasswordRequest;

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
            'idiomas'=>$idioma,
        ];

        return view('admin.usuarios.index',$datos);
    }

    public function createUserFast(Request $request){

        $validator = Validator::make($request->all(),[
            'nombre'=>'required',
            'telefono'=>'required',
            'ruc'=>'required|min:13',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'messages'=>$validator->messages()
            ]);
        }else{
            $password = $request->input('password');
            User::create([
                'name'=>$request->input('nombre'),
                'telefono'=>$request->input('telefono'),
                'ruc'=>$request->input('ruc'),
                'email'=>$request->input('email'),
                'password'=>md5($request->input('password')),
            ])->assignRole('Client');
            Notification::route('mail', $request->input('email'))->notify(new SendPassword($password));
            return response()->json([
                'status'=>200,
                'messages'=>'Cliente creado con exito'
            ]);
        }
        
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
            'idioma'=>$request->input('idioma'),
            'cedula'=>$request->input('cedula'),
            'ruc'=>$request->input('ruc'),
            'email'=>$request->input('email'),
            'estado'=>1,
            'password'=>md5($password1),
        ])->assignRole($request->input('roles')); 
        
        return redirect('admin/usuarios')->with('mensaje','Usuario registrado');
    }
   
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $rol = Role::all();
        $usuario=User::findOrFail($id);
        $idiomas=Idioma::get();
        return view('admin.usuarios.formEdit',compact('user','rol','idiomas','usuario'));
    }
    //asignar roles al usuario
    public function showPerfil()
    {
        $id = Auth::user()->id;
        $usuario = User::find($id);
        return view('admin.usuarios.perfil',compact('usuario'));
    }

    public function updatePerfil(Request $request, $id){
        $request->validate([
            'name'=>['required'],
            'telefono' => ['required'],
            'ruc'=>['required'],
            'cedula' => ['required'],
            'email' => ['required'],  
         ]);
        $users=User::findOrFail($id);
        $datos=array(
            'name'=>$request->input('name'),
            'telefono'=>$request->input('telefono'),
            'cedula'=>$request->input('cedula'),
            'ruc'=>$request->input('ruc'),
            'email'=>$request->input('email'),
        );
        User::whereid($id)->update($datos);

        return redirect('admin/perfil')->with('mensaje','Usuario Actualizado');
    }

    public function changePassword(Request $request, $id){
         $request->validate([
             'contraseña_actual'=>['required','min:8','string'],
            //  'nueva_contraseña' => ['required','min:8','string'],
            //  'confirmar_contraseña'=>['required','min:8','same:nueva_contraseña','string'], 
          ]);
         $usuario = User::find($id);
         $password = $usuario->password;
        
         if(md5($request->input('contraseña_actual'))==$password){
            $datos = [
                'password'=>md5($request->input('nueva_contraseña')),
            ];
            User::whereid($id)->update($datos);
            return redirect('admin/perfil')->with('mensaje','Contraseña actualizada!');
         }else{
            return redirect('admin/perfil')->with('mensaje','Contraseña actual incorrecta');
         }
    }

    public function resetPassword(Request $request, $id){
        $request->validate([
            'contraseña_actual'=>['required','min:8','string'],
           //  'nueva_contraseña' => ['required','min:8','string'],
           //  'confirmar_contraseña'=>['required','min:8','same:nueva_contraseña','string'], 
         ]);
        $usuario = User::find($id);
        $password = $usuario->password;
       
        if(md5($request->input('contraseña_actual'))==$password){
           $datos = [
               'password'=>md5($request->input('nueva_contraseña')),
           ];
           User::whereid($id)->update($datos);
           return redirect('admin/usuarios')->with('mensaje','Contraseña actualizada!');
        }else{
            return redirect()->route('admin.usuarios.edit',$id)->with('mensaje','Contraseña actual incorrecta');
        }
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
    public function destroyUser($id)
    {
        User::destroy($id);
        return redirect('usuarios')->with('mensaje','Adios!');
        Auth::logout();
    }
}
