<?php

namespace App\Http\Controllers;

use App\Models\Contenedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cotizaciones;

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

        $data = [];
        $data2 = [];
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

        $datos = [
            'data' => $data = json_encode($data),
            'data2' => $data2 = json_encode($data2),
            'usuarios' => $usuarios,
            'cotizaciones' => $cotizaciones,
            'pendientes' => $aprobadas,
            'aprobadas' => $pendientes,
            'contenedores' => $contenedores
        ];

        return view('home', $datos);
    }
}
