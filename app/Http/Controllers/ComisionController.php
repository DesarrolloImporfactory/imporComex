<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComisionController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        return datatables()->collection(Comision::all())->addColumn('action', function ($comision) {
            return '<a type="button" title="editar" class="text-center editComision" value="' . $comision->id . '"><i class="fa-solid fa-pen-to-square"></i></a>';
        })->toJson();
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'valor' => 'required | numeric',
            'valor_min' => 'required | numeric',
            'valor_max' => 'required | numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->messages()
            ]);
        } else {
            $data = new Comision();
            $data->valor = $request->input('valor');
            $data->valor_min = $request->input('valor_min');
            $data->valor_max = $request->input('valor_max');
            $data->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Registro creado con exito!'
            ]);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data = Comision::findOrFail($id);
        return response()->json([
            'status' => 200,
            'comision' => $data
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_valor' => 'required | numeric',
            'edit_valor_min' => 'required | numeric',
            'edit_valor_max' => 'required | numeric',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            Comision::where('id',$id)->update([
                'valor' => $request->input('edit_valor'),
                'valor_min' => $request->input('edit_valor_min'),
                'valor_max' => $request->input('edit_valor_max'),
            ]);
            return response()->json([
                'status' => 200,
                'mensaje' =>'Registro actualizado exitosamente!' ,
            ]);
        }
    }


    public function destroy($id)
    {
        //
    }
}
