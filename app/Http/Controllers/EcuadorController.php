<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;
use App\Models\Paises;
use App\Models\tipo_cargas;
use App\Models\User;
use App\Models\Incoterm;
use App\Models\Contenedores;
use App\Models\Cotizaciones;
use Illuminate\Support\Facades\Validator;
use App\Models\tarifaGruapl;

class EcuadorController extends Controller
{
   
    public function index(Request $request)
    {
        $producto=$request->input('modalidad');
        
        $modalidad = Modalidades::all();
        $pais = Paises::all();
        $carga = tipo_cargas::all();
        $incoterm = Incoterm::all();
        $contenedor = Contenedores::all();
        $cotizaciones = Cotizaciones::with('carga')->get();

        $data =[
            'modalidades' => $modalidad,
            'paises' => $pais,
            'cargas' => $carga,
            'incoterms'=>$incoterm,
            'contenedores' =>$contenedor,
            'cotizaciones'=>$cotizaciones
        ];
        
        if( $producto=="GRUPAL"){
            return view('admin.calculadoras.ecuador.grupal',$data);
        }elseif ( $producto=="FCL") {
            return view('admin.calculadoras.ecuador.fcl',$data);
        }else{
            return view('admin.calculadoras.ecuador.lcl',$data);
        }
       
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
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
