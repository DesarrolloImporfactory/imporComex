<?php

namespace App\Http\Controllers;

use App\Models\Suscripcion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $roles = Role::get();
        $permissions = Permission::where('sistema_id', '1')->get();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }


    public function create()
    {
        $usuario = Auth::user();
        $tipoSuscripcion = Suscripcion::where('estado', 'Activa')->where('usuario_id', $usuario->id)
            ->where('tipo_id', '3')->first();
        if (isset($tipoSuscripcion)) {
            $fecha_actual = Carbon::now()->startOfDay();
            $fecha_fin = Carbon::parse($tipoSuscripcion->fecha_fin)->startOfDay();

            $dias_restantes = $fecha_actual->diffInDays($fecha_fin);
            return response()->json([
                'status' => 200,
                'mensaje' => 'Usuario con suscripción demo.',
                'dias' => $dias_restantes,
                'fecha_fin' => $tipoSuscripcion->fecha_fin,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'mensaje' => 'Usuario normal.'
            ]);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::create($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.edit', $role)->with('mensaje', 'Rol creado');
        //return view('admin.roles.edit',$role)->with('mensaje','Rol creado');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::where('sistema_id', '1')->get();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        $permisos = Permission::where('sistema_id', '1')->get();;
        $data = [
            'role' => $role,
            'permisos' => $permisos

        ];

        return redirect()->route('admin.roles.edit', $role)->with('mensaje', 'Rol actualizado');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('mensaje', 'Rol Eliminado');
    }
}
