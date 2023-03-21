<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Impuesto;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{

    public function index()
    {
        $datos = Impuesto::all();
        return view('admin.impuestos.index', compact('datos'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'signo' => ['required']
        ]);
        if ($request->input('estado')) {
            $estado = $request->input('estado');
        } else {
            $estado = "off";
        }
        $datos = new Impuesto();
        $datos->nombre = $request->input('nombre');
        $datos->signo = $request->input('signo');
        $datos->estado = $estado;
        $datos->valor = $request->input('valor');

        $datos->save();

        return redirect('admin/impuestos')->with('mensaje', 'Impuesto creado!');
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
        if ($request->input('estado')) {
            $estado = $request->input('estado');
        } else {
            $estado = "off";
        }
        $datos = [
            'nombre' => $request->input('nombre'),
            'signo' => $request->input('signo'),
            'estado' => $estado,
            'valor' => $request->input('valor')
        ];
        Impuesto::whereid($id)->update($datos);
        return redirect('admin/impuestos')->with('mensaje', 'Impuesto actualizado!');
        //return $datos;
    }

    public function destroy($id)
    {
        Impuesto::destroy($id);
        return redirect('admin/impuestos')->with('mensaje', 'Impuesto Eliminado!');
    }
}
