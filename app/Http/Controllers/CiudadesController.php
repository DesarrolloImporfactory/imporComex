<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class CiudadesController extends Controller
{

    public function index()
    {
        return view('admin.ciudades.index');
    }


    public function create()
    {
        $ciudad = Ciudad::all();
        return DataTables::of($ciudad)
            ->addColumn('action', function ($ciudades) {
                return '<a type="button" title="editar" class="text-center edit" value="' . $ciudades->id . '"><i class="fa-solid fa-pen-to-square"></i></a>';
            })->toJson();
    }


    public function store(Request $request)
    {
        // return datatables()->collection(Ciudad::all())->addColumn('action', function($ciudades){
        //     return '<a type="button" title="editar" class="text-center edit" value="'.$ciudades->id.'"><i class="fa-solid fa-pen-to-square"></i></a>';
        // })->toJson();
    }


    public function show($id)
    {
        $ciudad = Ciudad::findOrFail($id);
        return response()->json([
            'status' => 200,
            'ciudad' => $ciudad
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'provincia' => 'required',
            'canton' => 'required',
            'tarifa' => 'required | numeric',
            'kilo' => 'required | numeric',
            'trayecto' => 'required',
            'tiemp_guayaquil' => 'required',
            'tiemp_quito' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            Ciudad::where('id', $id)->update([
                'provincia' => $request->input('provincia'),
                'canton' => $request->input('canton'),
                'tarifa' => $request->input('tarifa'),
                'kilo_adicional' => $request->input('kilo'),
                'tipo_trayecto' => $request->input('trayecto'),
                'tiemp_guayaquil' => $request->input('tiemp_guayaquil'),
                'tiemp_quito' => $request->input('tiemp_quito'),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Registro actualizado exitosamente!'
            ]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
