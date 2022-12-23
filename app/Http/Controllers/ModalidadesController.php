<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;
use App\Models\Incoterms;
use App\Models\Contenedores;
use App\Models\Estado;

class ModalidadesController extends Controller
{
   
    public function index()
    {
        $modalidades=Modalidades::get();
        $incoterms=Incoterms::get();
        $contenedores=Contenedores::get();
        $estados = Estado::get();
        $data=array(
            'modalidades'=>$modalidades,
            'incoterms'=>$incoterms,
            'contenedores'=>$contenedores,
            'estados'=>$estados
        );

        return view('admin.modalidades.index',$data);
    }

   
    public function store(Request $request)
    {
        $tipo = $request->input('tipo');
        if ($tipo=="mo") {
            $datosModalidades = new Modalidades;
        $datosModalidades->modalidad=$request->input('modalidad');
        $datosModalidades->save();
        return redirect('modalidades')->with('mensaje','Modalidad registrada');
        } else {
            $datosModalidades = new Incoterms;
            $datosModalidades->name=$request->input('name');
            $datosModalidades->save();
            return redirect('modalidades')->with('mensaje','Incoterms registrada');
        }
        
        
    }
   
    public function update(Request $request, $id)
    {
        $tipo=$request->input('tipo');
        if ($tipo=="mo") {
            $datos = array(
                "modalidad"=>$request->input('modalidad')
            );
            Modalidades::whereid($id)->update($datos);
            return redirect('modalidades')->with('mensaje','Modalid Actualizada');
        } else {
            $datos = array(
                "name"=>$request->input('name')
            );
            Incoterms::whereid($id)->update($datos);
            return redirect('modalidades')->with('mensaje','Incoterms Actualizado');
        }
        
        

    }

   
    public function destroy(Request $request, $id)
    {
        $tipo = $request->input('tipo');
        if ($tipo=="mo") {
            Modalidades::destroy($id);
            return redirect('modalidades')->with('mensaje','Modalidad Eliminada');
        } else {
            Incoterms::destroy($id);
            return redirect('modalidades')->with('mensaje','Incoterm Eliminada');
        }
        
        // Modalidades::destroy($id);
        // return redirect('modalidades')->with('mensaje','Modalidad Eliminada');
      
    }
}
