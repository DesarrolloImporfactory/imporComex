<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variables;
use Illuminate\Support\Facades\Validator;

class VariablesController extends Controller
{
    
    public function index()
    {
        $variables = Variables::all();
        return response()->json([
            'status' => 200,
            'variables' => $variables
        ]);
    }

    public function create()
    {
        return datatables()->collection(Variables::all())->addColumn('action', function($variables){
            return '<a type="button" title="editar" class="text-center editVariable" value="'.$variables->id.'"><i class="fa-solid fa-pen-to-square"></i></a>';
        })->toJson();
    }

    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        $variable = Variables::findOrFail($id);
        if(isset($variable)){
            return response()->json([
                'satus'=>200,
                'variable'=>$variable
            ]);
        }else{
            return response()->json([
                'satus'=>400,
            ]);
        }
    }

   
    public function edit($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'variable'=>'required',
            'valor'=>'required | numeric'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            Variables::where('id',$id)->update([
                'nombre' => $request->input('variable'),
                'valor' => $request->input('valor'),
                'minimo' => $request->input('minimo'),
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
