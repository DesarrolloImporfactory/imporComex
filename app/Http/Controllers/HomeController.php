<?php

namespace App\Http\Controllers;

use App\Models\Contenedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cotizaciones;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuarios = User::count();
        $cotizaciones = Cotizaciones::count();
        $aprobadas = Cotizaciones::whereestado('aprobado')->count();
        $pendientes = Cotizaciones::whereestado('pendiente')->count();
        $contenedores = Contenedores::count();

        $data = [];
        $data2 = [];
        $query = "
        SELECT count(*) as cotizaciones, users.name as usuario from cotizaciones inner join users on cotizaciones.especialista_id= users.id GROUP BY(users.name)
        ";
        $consultas = DB::select($query);

        $query2 = "
        SELECT count(*) as cotizaciones, paises.nombre_pais as pais from cotizaciones inner join paises on cotizaciones.pais_id= paises.id GROUP BY(paises.nombre_pais)
        ";
        $consultas2 = DB::select($query2);

        foreach ($consultas as $consulta) {
            $data['label'][] = $consulta->usuario;
            $data['data'][] = $consulta->cotizaciones;
        }

        foreach ($consultas2 as $consulta2) {
            $data2['label'][] = $consulta2->pais;
            $data2['data'][] = $consulta2->cotizaciones;
        }

        $datos = [
            'data' => $data['data'] = json_encode($data),
            'data2' => $data2['data'] = json_encode($data2),
            'usuarios'=>$usuarios,
            'cotizaciones'=>$cotizaciones,
            'pendientes'=>$aprobadas,
            'aprobadas'=>$pendientes,
            'contenedores'=>$contenedores
        ];

        return view('home', $datos);
    }
}
