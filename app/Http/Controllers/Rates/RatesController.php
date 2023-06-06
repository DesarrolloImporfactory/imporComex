<?php

namespace App\Http\Controllers\Rates;

use App\Http\Controllers\Controller;
use App\Models\Tarifario;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RatesController extends Controller
{

    public function index()
    {
        //
    }

    public function redirectSuit()
    {
        if (Auth::check()) {
            $otherAppUrl = 'http://194.163.183.231:8085/';
            return Redirect::away($otherAppUrl);
        }
    }
    public function create()
    {
        $tarifas = Tarifario::all();
        return DataTables::of($tarifas)
            ->addColumn('action', function ($tarifa) {
                return '<a class="" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-bars"></i></a><ul class="dropdown-menu">
    <li><a class="dropdown-item editarTarifa" value="' . $tarifa->id . '" ><i class="bi bi-pencil-square"></i>Editar</a></li>
    <li>
        <a class="dropdown-item delete-tarifa" value="' . $tarifa->id  . '"><i class="fa-solid fa-trash"></i> Eliminar</a>
    </li>
</ul>';
            })->toJson();
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transporte' => 'required',
                'origen' => 'required',
                'destino' => 'required',
                'peso_min' => 'required | numeric',
                'peso_max' => 'required| numeric',
                'costo' => 'required| numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {
                Tarifario::create([
                    'transporte' => $request->input('transporte'),
                    'origen' => $request->input('origen'),
                    'destino' => $request->input('destino'),
                    'peso_min' => $request->input('peso_min'),
                    'peso_max' => $request->input('peso_max'),
                    'costo' => $request->input('costo'),
                ]);
                return response()->json([
                    'status' => 200,
                    'messages' => 'Registro creado con exito!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'errors' => 'Error al ingresar informacion: ' . $e->getMessage()
            ]);
        }
    }


    public function show($id)
    {
        try {
            $tarifa = Tarifario::findOrFail($id);

            return response()->json([
                'status' => 200,
                'tarifa' => $tarifa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al obtener la tarifa: ' . $e->getMessage()
            ]);
        }
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transporte' => 'required',
                'origen' => 'required',
                'destino' => 'required',
                'peso_min' => 'required | numeric',
                'peso_max' => 'required| numeric',
                'costo' => 'required| numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages(),
                ]);
            } else {

                Tarifario::where('id', $id)->update([
                    'transporte' => $request->input('transporte'),
                    'origen' => $request->input('origen'),
                    'destino' => $request->input('destino'),
                    'peso_min' => $request->input('peso_min'),
                    'peso_max' => $request->input('peso_max'),
                    'costo' => $request->input('costo'),
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Registro actualizado exitosamente!'
                ]);
            }
        } catch (\Exception $e) {
            // Manejo de la excepción
            return response()->json([
                'status' => 500,
                'errors' => 'Error al actualizar el registro: ' . $e->getMessage()
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            Tarifario::destroy($id);
            return response()->json([
                'status' => 200,
                'message' => 'Registro eliminado exitosamente!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'errors' => 'Error al eliminar: ' . $e->getMessage(),
            ]);
        }
    }
}
