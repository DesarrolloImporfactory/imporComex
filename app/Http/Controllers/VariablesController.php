<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variables;
use App\Models\VariablesFcl;
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

    public function create(Request $request)
    {
        $modalidad = $request->input('modalidad');
        $operacion = $request->input('operacion');

        $query = Variables::with('operacion', 'modalidad');

        if ($modalidad) {
            $query->where('modalidad_id', $modalidad);
        }

        if ($operacion) {
            $query->where('operacion_id', $operacion);
        }

        $data = $query->get();

        return datatables()->collection($data)->addColumn('action', function ($variables) {
            return '<a type="button" title="editar" class="text-center editVariable" value="' . $variables->id . '"><i class="fa-solid fa-pen-to-square"></i></a>
        <a type="button" title="eliminar" class="text-center deleteVariable text-danger" value="' . $variables->id . '"><i class="fa-solid fa-trash-can"></i></a>';
        })->toJson();
    }

    public function variables()
    {
        return datatables()->collection(VariablesFcl::all())->addColumn('action', function ($variables) {
            return '<a type="button" title="editar" class="text-center editFcl" value="' . $variables->id . '"><i class="fa-solid fa-pen-to-square"></i></a>';
        })->toJson();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_variable' => 'required',
                'valor_variable' => 'required | numeric',
                'tipo_modalidad' => 'required',
                'tipo_operacion' => 'required',
                'tipo_gasto' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {
                Variables::create([
                    'nombre' => $request->input('nombre_variable'),
                    'valor' => $request->input('valor_variable'),
                    'minimo' => $request->input('valor_extra'),
                    'modalidad_id' => $request->input('tipo_modalidad'),
                    'operacion_id' => $request->input('tipo_operacion'),
                    'tipo' => $request->input('tipo_gasto'),
                ]);
                return response()->json([
                    'status' => 200,
                    'mensaje' => 'Registro creado exitosamente!',
                ]);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 200,
                'mensaje' => $th->getMessage(),
            ]);
        }
    }


    public function show($id)
    {
        $variable = Variables::findOrFail($id);
        if (isset($variable)) {
            return response()->json([
                'satus' => 200,
                'variable' => $variable
            ]);
        } else {
            return response()->json([
                'satus' => 400,
            ]);
        }
    }


    public function edit($id)
    {
        $variable = VariablesFcl::findOrFail($id);
        if (isset($variable)) {
            return response()->json([
                'satus' => 200,
                'variable' => $variable
            ]);
        } else {
            return response()->json([
                'satus' => 400,
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'variable' => 'required',
                'valornew' => 'required | numeric',
                'modalidad' => 'required',
                'operacion' => 'required',
                'tipo' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {
                Variables::where('id', $id)->update([
                    'nombre' => $request->input('variable'),
                    'valor' => $request->input('valornew'),
                    'minimo' => $request->input('minimo'),
                    'modalidad_id' => $request->input('modalidad'),
                    'operacion_id' => $request->input('operacion'),
                    'tipo' => $request->input('tipo'),
                ]);
                return response()->json([
                    'status' => 200,
                    'mensaje' => 'Registro actualizado exitosamente!',
                ]);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 200,
                'mensaje' => $th->getMessage(),
            ]);
        }
    }

    public function updatefcl(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'variablefcl' => 'required',
                'valorfcl' => 'required | numeric'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {
                VariablesFcl::where('id', $id)->update([
                    'nombre' => $request->input('variablefcl'),
                    'valor' => $request->input('valorfcl'),
                    'minimo' => $request->input('minimofcl'),
                ]);
                return response()->json([
                    'status' => 200,
                    'mensaje' => 'Registro actualizado exitosamente!',
                ]);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 400,
                'mensaje' => $th->getMessage(),
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            Variables::destroy($id);
            return response()->json([
                'status' => 200,
                'mensaje' => 'Registro eliminado exitosamente!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'mensaje' => $e->getMessage(),
            ]);
        }
    }
}
