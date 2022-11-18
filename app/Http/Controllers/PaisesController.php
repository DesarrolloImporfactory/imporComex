<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paises;

class PaisesController extends Controller
{
  
    public function index()
    {
        $datos['paises']=Paises::get();
        return view('admin.paises.index',$datos);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $datosPaises = new Paises();
        $datosPaises->nombre_pais=$request->input('nombre_pais');
        $datosPaises->save();
        return redirect('paises')->with('mensaje','Pais registrado');
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
            "nombre_pais"=>$request->input('nombre_pais')
        );
        Paises::whereid($id)->update($datos);
        return redirect('paises')->with('mensaje','Pais Actualizado');
    }

    
    public function destroy($id)
    {
        Paises::destroy($id);
        return redirect('paises')->with('mensaje','Pais Eliminado');
    }
}
