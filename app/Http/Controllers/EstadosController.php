<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE App\Models\Estado;

class EstadosController extends Controller
{
    
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
