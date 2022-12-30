<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paises;
use App\Models\Incoterm;
use App\Models\CoIndividual;
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
        return view('admin.calculadoras.cotizaciones.index',compact('paises','incoterms'));
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'origen_id'=>['required'],
            'destino_id'=>['required'],
            'proveedores'=>['required'],
            'incoterms_id'=>['required'],
            'valor'=>['required'],
            'peso'=>['required'],
            'productos'=>['required'],
            'volumen'=>['required'],
        ]);

        $data = User::latest('created_at')->whereHas("roles", function($q){ $q->where("name", "Especialista"); })->first();
        if (isset($data)) {
           $idEspecialistaNuevo=$data->id;
        } 
    
       //codigo para traer el especialista con menor cantidad de cotizaciones asignadas
       $query= "
       select count(id) as cotizaciones, especialista_id from cotizaciones where estado='aprobado' or estado='pendiente' group by especialista_id";

       $consulta = DB::select($query);
       //condicion para saber si existe cotizaciones asignadas
        if (count($consulta)>0) {
            $id=min($consulta);
            $idEspecialistaExistente=$id->especialista_id;
            if ($idEspecialistaNuevo != $idEspecialistaExistente) {
                $especialista = $idEspecialistaNuevo;
            } else {
                $especialista=$idEspecialistaExistente;
            }
        } else {
            
            $especialista=$idEspecialistaNuevo;
        }
        
        $datos = new CoIndividual();
        $datos->usuario_id=$request->input('usuario_id');
        $datos->especialista_id=$especialista;
        $datos->origen_id=$request->input('origen_id');
        $datos->destino_id=$request->input('destino_id');
        $datos->proveedores=$request->input('proveedores');
        $datos->incoterms_id=$request->input('incoterms_id');
        $datos->valor=$request->input('valor');
        $datos->peso=$request->input('peso');
        $datos->productos=$request->input('productos');
        $datos->volumen=$request->input('volumen');
        $datos->direccion=$request->input('direccion');

        $datos->save();

        return redirect()->route('admin.individual.create')->with('mensaje','Cotizacion creada!');
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
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
