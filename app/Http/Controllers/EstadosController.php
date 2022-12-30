<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE App\Models\Estado;

class EstadosController extends Controller
{
    // public function __construct()
    // {
        
    //     $this->middleware('can:admin.estados.store')->only('store');
    //     $this->middleware('can:admin.estados.update')->only('update');
    //     $this->middleware('can:admin.estados.destroy')->only('destroy');
    // }

    public function index()
    {
        //
    }

   
    public function create()
    {
        
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
        ]);
        $datos = request()->except('_token');
        Estado::insert($datos);
        return redirect()->route('admin.modalidades.index');
    }


  
    public function update(Request $request, $id)
    {
        $datos = request()->except(['_token','_method']);
        Estado::whereid($id)->update($datos);
        return redirect()->route('admin.modalidades.index');
    }

 
    public function destroy($id)
    {
        Estado::destroy($id);
        return redirect()->route('admin.modalidades.index');
    }
}
