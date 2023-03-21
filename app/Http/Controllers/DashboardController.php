<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paises;
use App\Models\User;
use App\Models\Cotizaciones;
use App\Models\Contenedores;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function all(Request $request)
    {
        $usuarios = Paises::count();
        return response()->json($usuarios);
    }

    public function clientes(){
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        return response()->json([
            'status'=>200,
            'clientes'=>$clientes
        ]);
    }

    public function totalCotizaciones($id)
    {
        $usuarios = User::count();
        $contenedores = Contenedores::count();

       
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
                'pendientes' => $cotizacionesPendientes,
                'usuarios'=>$usuarios,
                'contenedores'=>$contenedores
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
                'pendientes' => $cotizacionesPendientes,
                'usuarios'=>$usuarios,
                'contenedores'=>$contenedores
            ];
            return response()->json($data);
        }
    }

    public function grafica1(Request $request)
    {
        $query = "
        SELECT count(*) as cotizaciones, users.name as Usuario from cotizaciones inner join users on cotizaciones.especialista_id= users.id GROUP BY(users.name)
        ";

        $consulta = DB::select($query);
        return $consulta;
    }

    public function cotizacionesPendientes(Request $request)
    {
        $usuarios = Paises::count();
        return response()->json($usuarios);
    }
}
