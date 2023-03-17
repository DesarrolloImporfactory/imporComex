<?php

namespace App\Http\Controllers;

use App\Models\AjusteCotizacion;
use App\Models\CabeceraTransaccion;
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
        //
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
        //
    }
}
