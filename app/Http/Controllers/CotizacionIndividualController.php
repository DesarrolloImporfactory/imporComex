<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use App\Models\Paises;
use App\Models\Incoterm;
use App\Models\CoIndividual;
use App\Models\Insumo;
use App\Models\Puerto;
use App\Models\Tarifario;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CotizacionIndividualController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        $paises = Paises::all();
        $incoterms = Incoterm::all();
        $ciudades = Ciudad::all();
        $puertos = Puerto::all();
        $tarifarios = Tarifario::all();
        $productos = Insumo::all();
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();

        $mensajes = [
            'paises' => $paises,
            'clientes' => $clientes,
            'ciudades' => $ciudades,
            'puertos' => $puertos,
            'tarifarios' => $tarifarios,
            'productos' => $productos,
            'incoterms' => $incoterms
        ];

        return view('admin.calculadoras.cotizaciones.index', $mensajes);
    }


    public function store(Request $request)
    {
        $request->validate([
            'origen_id' => ['required'],
            'destino_id' => ['required'],
            'proveedores' => ['required'],
            'incoterms_id' => ['required'],
            'valor' => ['required'],
            'peso' => ['required'],
            'productos' => ['required'],
            'volumen' => ['required'],
        ]);

        $data = User::latest('created_at')->whereHas("roles", function ($q) {
            $q->where("name", "Especialista");
        })->first();
        if (isset($data)) {
            $idEspecialistaNuevo = $data->id;
        }

        //codigo para traer el especialista con menor cantidad de cotizaciones asignadas
        $query = "
       select count(id) as cotizaciones, especialista_id from cotizaciones where estado='aprobado' or estado='pendiente' group by especialista_id";

        $consulta = DB::connection('imporcomex')->select($query);
        //condicion para saber si existe cotizaciones asignadas
        if (count($consulta) > 0) {
            $id = min($consulta);
            $idEspecialistaExistente = $id->especialista_id;
            if ($idEspecialistaNuevo != $idEspecialistaExistente) {
                $especialista = $idEspecialistaNuevo;
            } else {
                $especialista = $idEspecialistaExistente;
            }
        } else {

            $especialista = $idEspecialistaNuevo;
        }

        $datos = new CoIndividual();
        $datos->usuario_id = $request->input('usuario_id');
        $datos->especialista_id = $especialista;
        $datos->origen_id = $request->input('origen_id');
        $datos->destino_id = $request->input('destino_id');
        $datos->proveedores = $request->input('proveedores');
        $datos->incoterms_id = $request->input('incoterms_id');
        $datos->valor = $request->input('valor');
        $datos->peso = $request->input('peso');
        $datos->productos = $request->input('productos');
        $datos->volumen = $request->input('volumen');
        $datos->direccion = $request->input('direccion');

        $datos->save();

        return redirect()->route('admin.individual.create')->with('mensaje', 'Cotizacion creada!');
    }


    public function show($id)
    {
        $puertos = Incoterm::where('puerto_id', $id)->get();
        if (count($puertos) > 0) {
            return response()->json([
                'status' => 200,
                'puertos' => $puertos
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'puertos' => 'No hay datos'
            ]);
        }
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
