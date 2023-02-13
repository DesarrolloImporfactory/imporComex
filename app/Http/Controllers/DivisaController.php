<?php

namespace App\Http\Controllers;

use App\Models\Divisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisaController extends Controller
{

    public function index()
    {
        $divisas = Divisa::all();
        return response()->json([
            'status' => 200,
            'datos' => $divisas
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $divisas = Divisa::find($id);
        if ($divisas) {
            return response()->json([
                'status' => 200,
                'divisas' => $divisas
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'El item seleccionado no existe'
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tarifa' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $datos = [
                'tarifa'=>$request->input('tarifa')/100
            ];
            Divisa::where('id',$id)->update($datos);
            return response()->json([
                'status' => 200,
                'message' => 'Valor actualizado exitosamente!'
            ]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
