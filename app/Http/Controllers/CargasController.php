<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo_cargas;
use App\Models\tarifaGruapl;

class CargasController extends Controller
{
    
    public function index()
    {
        $carga=tipo_cargas::get();
        $tarifa=tarifaGruapl::get();
        $datos = array(
            'cargas'=>$carga,
            'tarifas'=>$tarifa
        );
        return view('admin.cargas.index',$datos);
    }
    
    public function store(Request $request)
    {
        $datosCarga= new tipo_cargas();
        $datosCarga->tipoCarga=$request->input('tipoCarga');
        $datosCarga->save();
        return redirect('cargas')->with('mensaje','Carga Registrada');
    }
   
    public function updateTarifa(Request $request, $id)
    {
        $datos=array(
            "m3"=>$request->input('m3'),
            "vxcbm"=>$request->input('vxcbm'),
            "tcbm"=>$request->input('tcbm')
        );
        tarifaGruapl::whereid($id)->update($datos);
        return redirect('cargas')->with('mensaje','Tarifa Actualizada');
    }

    
    public function update(Request $request, $id)
    {
        $datos=array(
            "tipoCarga"=>$request->input('tipoCarga')
        );
        tipo_cargas::whereid($id)->update($datos);
        return redirect('cargas')->with('mensaje','Carga Actualizada');
    }

   
    public function destroy($id)
    {
        tipo_cargas::destroy($id);
        return redirect('cargas')->with('mensaje','Carga Eliminada');
    }
}
