<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;

class ModalidadesController extends Controller
{
   
    public function index()
    {
        $datos['modalidades']=Modalidades::get();
        return view('admin.modalidades.index',$datos);
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $datosModalidades = new Modalidades;
        $datosModalidades->modalidad=$request->input('modalidad');
        $datosModalidades->save();
        return redirect('modalidades')->with('mensaje','Modalidad registrada');
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
        $datos = array(
            "modalidad"=>$request->input('modalidad')
        );
        Modalidades::whereid($id)->update($datos);
        return redirect('modalidades')->with('mensaje','Modalid Actualizada');

    }

   
    public function destroy($id)
    {
        Modalidades::destroy($id);
        return redirect('modalidades')->with('mensaje','Modalidad Eliminada');
    }
}
