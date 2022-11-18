<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo_cargas;

class CargasController extends Controller
{
    
    public function index()
    {
        $datos['cargas']=tipo_cargas::get();
        return view('admin.cargas.index',$datos);
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $datosCarga= new tipo_cargas();
        $datosCarga->tipoCarga=$request->input('tipoCarga');
        $datosCarga->save();
        return redirect('cargas')->with('mensaje','Carga Registrada');
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
