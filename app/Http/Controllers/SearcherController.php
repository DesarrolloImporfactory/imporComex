<?php

namespace App\Http\Controllers;

use App\Models\ArancelPartida;
use Illuminate\Http\Request;
use App\Models\Idioma;
use App\Models\Paises;
use Illuminate\Support\Facades\DB;

class SearcherController extends Controller
{
    
    public function index()
    {
        $paises = Paises::all();
        return view('admin.searcher.index',compact('paises'));
    }

    public function searchDescripcion(Request $request){
        $term = $request->term;
        $data = DB::table('arancel_partidas')
        ->where('descripcion', 'LIKE', "%$term%")
        ->get();
        if(count($data)== 0){
             $respuesta[] = "No existen coincidencias";
        }else{
            foreach ($data as  $value) {
                $respuesta[] = [
                    'label' => $value->descripcion,
                    'id'=> $value->id
                ];
            }
        }
        return $respuesta;
    }

    public function searchPartida(Request $request){
        
        $term = $request->term;
        $data = DB::table('arancel_partidas')
        ->where('descripcion', 'LIKE', "%$term%")
        ->get();
        if(count($data)== 0){
             $respuesta[] = "No existen coincidencias";
        }else{
            foreach ($data as  $value) {
                $respuesta[] = [
                    'label' => $value->descripcion,
                    'id'=> $value->id
                ];
            }
        }
        return $respuesta;
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
