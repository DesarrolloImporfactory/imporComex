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
use Illuminate\Support\Facades\Redirect;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.usuarios.index')->only('index');
        $this->middleware('can:admin.usuarios.edit')->only('edit', 'update');
    }

    public function index()
    {
        $usuario = User::get();
        $idioma = Idioma::get();
        $datos = [
            'usuarios' => $usuario,
            'idiomas' => $idioma,
        ];

        return view('admin.usuarios.view', $datos);
    }

    public function createUserFast(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'telefono' => 'required',
            'ruc' => 'required|min:13',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->messages()
            ]);
        } else {
            try {
                $password = $request->input('password');
                User::create([
                    'name' => $request->input('nombre'),
                    'telefono' => $request->input('telefono'),
                    'ruc' => $request->input('ruc'),
                    'email' => $request->input('email'),
                    'password' => md5($request->input('password')),
                ])->assignRole('Client');
                Notification::route('mail', $request->input('email'))->notify(new SendPassword($password));
                return response()->json([
                    'status' => 200,
                    'messages' => 'Cliente creado con exito'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 202,
                    'messages' => $e->getMessage()
                ]);
            }
        }
    }


    public function create()
    {
        $roles = Role::get();
        $usuario = User::get();
        $idioma = Idioma::get();
        $datos = [
            'roles' => $roles,
            'usuarios' => $usuario,
            'idiomas' => $idioma
        ];
        return view('admin.usuarios.formCreate', $datos);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'roles' => ['required'],

        ]);
        if ($request->input('verificar') == 1) {
            $verificar = Carbon::now();
        } else {
            $verificar = NULL;
        }
        $password1 = $request->input('password');
        User::create([
            'name' => $request->input('name'),
            'telefono' => $request->input('telefono'),
            'date' => $request->input('date'),
            'idioma' => $request->input('idioma'),
            'cedula' => $request->input('cedula'),
            'ruc' => $request->input('ruc'),
            'email' => $request->input('email'),
            'estado' => 1,
            'email_verified_at' => $verificar,
            'password' => md5($password1),
        ])->assignRole($request->input('roles'));
        Notification::route('mail', $request->input('email'))->notify(new SendPassword($password1));
        return redirect('admin/usuarios')->with('mensaje', 'Usuario registrado');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $rol = Role::all();
        // $usuario=User::findOrFail($id);
        $usuario = User::with('roles')->findOrFail($id);
        $idiomas = Idioma::get();
        return view('admin.usuarios.formEdit', compact('user', 'rol', 'idiomas', 'usuario'));
    }
    //asignar roles al usuario
    public function showPerfil()
    {
        $id = Auth::user()->id;
        $usuario = User::find($id);
        return view('admin.usuarios.perfil', compact('usuario'));
    }

    public function updatePerfil(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'telefono' => ['required'],
            'ruc' => ['required'],
            'cedula' => ['required'],
            'email' => ['required'],
        ]);
        $users = User::findOrFail($id);
        $datos = array(
            'name' => $request->input('name'),
            'telefono' => $request->input('telefono'),
            'cedula' => $request->input('cedula'),
            'ruc' => $request->input('ruc'),
            'email' => $request->input('email'),
        );
        User::whereid($id)->update($datos);

        return redirect('admin/perfil')->with('mensaje', 'Usuario Actualizado');
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'contraseña_actual' => ['required', 'min:8', 'string'],
        ]);
        $usuario = User::find($id);
        $password = $usuario->password;

        if (md5($request->input('contraseña_actual')) == $password) {
            $datos = [
                'password' => md5($request->input('nueva_contraseña')),
            ];
            User::whereid($id)->update($datos);
            return redirect('admin/perfil')->with('mensaje', 'Contraseña actualizada!');
            Notification::route('mail', $usuario->email)->notify(new SendPassword($request->input('contraseña_actual')));
        } else {
            return redirect('admin/perfil')->with('mensaje', 'Contraseña actual incorrecta');
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'contraseña_actual' => ['required', 'min:8', 'string'],
        ]);
        $usuario = User::find($id);
        $password = $usuario->password;

        if (md5($request->input('contraseña_actual')) == $password) {
            $datos = [
                'password' => md5($request->input('nueva_contraseña')),
            ];
            User::whereid($id)->update($datos);
            Notification::route('mail', $usuario->email)->notify(new SendPassword($request->input('contraseña_actual')));
            return redirect('admin/usuarios')->with('mensaje', 'Contraseña actualizada!');
        } else {
            return redirect()->route('admin.usuarios.edit', $id)->with('mensaje', 'Contraseña actual incorrecta');
        }
    }

    public function update(Request $request, $user)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'roles' => ['required'],

        ]);

        $users = User::findOrFail($user);
        if ($request->input('password') == $users->password) {
            $password = $users->password;
        } else {
            $password = md5($request->input('password'));
        }
        $datos = array(
            'name' => $request->input('name'),
            'telefono' => $request->input('telefono'),
            'date' => $request->input('date'),
            'importacion' => $request->input('importacion'),
            'idioma' => $request->input('idioma'),
            'estado' => $request->input('estado'),
            'cedula' => $request->input('cedula'),
            'password' => $password,
            'ruc' => $request->input('ruc'),
            'email' => $request->input('email'),
        );

        User::whereid($user)->update($datos);
        $users->roles()->sync($request->roles);
        //User::whereid($user)->update($datos);
        return redirect('admin/usuarios')->with('mensaje', 'Roles Asignados');
    }


    public function destroy($id)
    {
        User::destroy($id);
        return redirect('admin/usuarios')->with('mensaje', 'Usuario Eliminado');
    }

    public function destroyUser($id)
    {
        User::destroy($id);
        return redirect('usuarios')->with('mensaje', 'Adios!');
        Auth::logout();
    }

    public function redirectSuit(Request $request)
    {
        if (Auth::check()) {
            $sessionId = $request->session()->getId();
            $otherAppUrl = 'https://herramientas.imporsuit.app/home';
            return Redirect::away($otherAppUrl);
        }
    }
}
