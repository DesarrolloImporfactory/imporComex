<?php

namespace App\Http\Controllers;

use App\Models\Contenedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cotizaciones;
use App\Models\Insumo;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $usuarios = User::count();
        $cotizaciones = Cotizaciones::count();
        $aprobadas = Cotizaciones::whereestado('aprobado')->count();
        $pendientes = Cotizaciones::whereestado('pendiente')->count();
        $contenedores = Contenedores::count();

        $usuariosConMasInsumos = Insumo::select('users.name', DB::raw('count(*) as total'))
            ->join('users', 'insumos.usuario_id', '=', 'users.id')
            ->whereNotNull('insumos.usuario_id')
            ->groupBy('users.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        $data = [];
        $data2 = [];
        $data3 = [];
        $query = "
        SELECT count(*) as cotizaciones, users.name as usuario from cotizaciones inner join users on cotizaciones.especialista_id= users.id GROUP BY(users.name)
        ";
        $consultas = DB::connection('imporcomex')->select($query);

        $query2 = "
        SELECT COUNT(*) AS cotizaciones, users.name AS user FROM cotizaciones INNER JOIN users ON cotizaciones.usuario_id = users.id GROUP BY users.name ORDER BY cotizaciones DESC LIMIT 5;
        ";
        $consultas2 = DB::connection('imporcomex')->select($query2);
        foreach ($consultas as $consulta) {
            $data[] = [
                'name' => $consulta->usuario,
                'y' => $consulta->cotizaciones
            ];
        }

        foreach ($consultas2 as $consulta2) {
            $data2[] = [
                'name' => $consulta2->user,
                'y' => $consulta2->cotizaciones
            ];
        }

        foreach ($usuariosConMasInsumos as $item) {
            $data3[] = [
                'name' => $item->name,
                'y' => $item->total
            ];
        }

        $datos = [
            'data' => $data = json_encode($data),
            'data2' => $data2 = json_encode($data2),
            'data3' => $data3 = json_encode($data3),
            'usuarios' => $usuarios,
            'cotizaciones' => $cotizaciones,
            'pendientes' => $aprobadas,
            'aprobadas' => $pendientes,
            'contenedores' => $contenedores,
            'productos' => Insumo::with('usuario')->whereNotNull('usuario_id')->get(),
        ];

        $id = auth()->user()->id;
        $usuarioRol = User::with('roles')->findOrFail($id);
        foreach ($usuarioRol->roles as $rol) {
            $usuario = $rol->name;
        }

        if ($usuario == "Admin"  || $usuario == "Especialista") {

            return view('home', $datos);
        } else {
            return view('admin.dashboard.clientDashboard', $this->cliente($id));
        }
    }

    public function cliente($id)
    {
        $cotizaciones = Cotizaciones::with('modalidad', 'especialista')->where('usuario_id', $id)->get();
        $productos = Insumo::with('usuario')->where('usuario_id', $id)->get();
        $data1 = [];
        $cotizacionesModalidad = Cotizaciones::with('modalidad')
            ->where('usuario_id', $id)
            ->groupBy('modalidad_id')
            ->select('modalidad_id', DB::raw('COUNT(*) as total'))
            ->get();


        foreach ($cotizacionesModalidad as $consulta) {
            $data1[] = [
                'name' => $consulta->modalidad->modalidad,
                'y' => $consulta->total
            ];
        }

        $datos = [
            'data1' => $data1 = json_encode($data1),
            'cotizacionesTotal' => $cotizaciones->count(),
            'productosTotal' => $productos->count(),
            'cotizaciones' => $cotizaciones,
            'productos' => $productos
        ];

        return $datos;
    }
}
