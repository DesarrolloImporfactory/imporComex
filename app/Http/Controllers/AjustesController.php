<?php

namespace App\Http\Controllers;

use App\Models\AjusteCotizacion;
use App\Models\CabeceraTransaccion;
use App\Models\Calculadora;
use App\Models\Cotizaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjustesController extends Controller
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
        $validator = Validator::make($request->all(), [
            'insumo_id' => 'required',
            'cartones' => 'required',
            'largo' => 'required',
            'ancho' => 'required',
            'alto' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => $validator->messages()
            ]);
        } else {
            Calculadora::create([
                'cotizacion_id' => $request->input('cotizacion_id'),
                'insumo_id' => $request->input('insumo_id'),
                'cartones' => $request->input('cartones'),
                'largo' => $request->input('largo'),
                'ancho' => $request->input('ancho'),
                'alto' => $request->input('alto'),
                'total' => (($request->input('largo') * $request->input('ancho') * $request->input('alto')) / 1000000) * $request->input('cartones'),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Registro actualizado exitosamente!',
            ]);
        }
    }

    public function total($id)
    {
        try {
            $calculos = Calculadora::where('cotizacion_id', $id)->get();
            $total = 0;
            foreach ($calculos as  $calculo) {
                $total = $total + $calculo->total;
            }
            return response()->json([
                'status' => 200,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $data = Cotizaciones::findOrFail($id);
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        try {
            $calculos = Calculadora::with('producto')->where('cotizacion_id', $id)->get();
            return response()->json([
                'status' => 200,
                'calculos' => $calculos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'accion' => 'required',
            'valor' => 'required | numeric',
            'motivo' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $cotizacion = Cotizaciones::findOrFail($id);
            if ($request->input('accion') == 1) {
                $total = $cotizacion->total + $request->input('valor');
            } else {
                $total = $cotizacion->total - $request->input('valor');
            }
            Cotizaciones::where('id', $id)->update([
                'total' => $total
            ]);
            CabeceraTransaccion::where('cotizacion_id', $id)->update([
                'saldo' => $total
            ]);
            $ajuste = new AjusteCotizacion();
            $ajuste->cotizacion_id = $id;
            $ajuste->valor = $request->input('valor');
            $ajuste->motivo = $request->input('motivo');
            $ajuste->save();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Registro actualizado exitosamente!',
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            Calculadora::destroy($id);
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }
}
