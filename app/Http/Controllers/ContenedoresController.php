<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenedores;

class ContenedoresController extends Controller
{
  
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'estado_id' => ['required'],
           
         ]);

        $datos =request()->except('_token');
        Contenedores::insert($datos);
        return redirect()->route('admin.modalidades.index');
    }

  
   
    public function update(Request $request, $id)
    {
        $datos =request()->except(['_token','_method']);
        Contenedores::whereid($id)->update($datos);
        return redirect()->route('admin.modalidades.index');
    }

    
    public function destroy($id)
    {
        Contenedores::destroy($id);
        return redirect()->route('admin.modalidades.index');
    }
}
