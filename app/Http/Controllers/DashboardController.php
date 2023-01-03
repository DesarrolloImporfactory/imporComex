<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paises;
use App\Models\User;
use App\Models\Cotizaciones;

class DashboardController extends Controller
{

    public function all(Request $request)
    {
        $usuarios = Paises::count();
        return response()->json($usuarios);
    }

    public function totalCotizaciones(Request $request)
    {

        $id = $request->input('id');
        $usuarioRol = User::with('roles')->findOrFail($id);
        //foreach para mapear la consulta anidada
        foreach ($usuarioRol->roles as $rol) {
            $usuario = $rol->name;
        }

        if ($usuario == "Admin") {
            //$listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
            $data = [
                'cotizaciones' => $cotizaciones,
                'aprobadas' => $cotizacionesAprobadas,
                'pendientes' => $cotizacionesPendientes
            ];
            return response()->json($data);
        } else {
            //$listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereusuario_id($id)->get();
            $cotizaciones = Cotizaciones::where('usuario_id', $id)->count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();

            $data = [
                'cotizaciones' => $cotizaciones,
                'aprobadas' => $cotizacionesAprobadas,
                'pendientes' => $cotizacionesPendientes
            ];
            return response()->json($data);
        }
    }

    public function cotizacionesAprobadas(Request $request)
    {
        $usuarios = Paises::count();
        return response()->json($usuarios);
    }

    public function cotizacionesPendientes(Request $request)
    {
        $usuarios = Paises::count();
        return response()->json($usuarios);
    }
}
