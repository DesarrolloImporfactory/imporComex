<?php

namespace App\Http\Controllers;

use App\Models\CabeceraTransaccion;
use App\Models\DetalleTransaccion;
use App\Models\FormaPago;
use App\Models\Transaccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuentasController extends Controller
{

    public function index()
    {
        $cuentas = CabeceraTransaccion::with([
            'cotizacion' => function ($q) {
                $q->with(['usuario' => function ($q) {
                }]);
            }
        ])->get();
        return view('admin.cobros.index', compact('cuentas'));
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'valor' => 'required | numeric',
            'pago_id' => 'required ',
            'transaccion_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $data = new DetalleTransaccion();
            $data->pago_id = $request->input('pago_id');
            $data->transaccion_id = $request->input('transaccion_id');
            $data->valor = $request->input('valor');
            $data->cabecera_id = $request->input('cabecera_id');
            $data->fecha_vencimiento = Carbon::now();
            $data->save();
            $this->saldo($request->input('cabecera_id'), $request->input('valor'));
            return response()->json([
                'status' => 200,
                'mensaje' => 'Abono registrado exitosamente!',
            ]);
        }
    }

    public function saldo($id, $valor)
    {
        $data = CabeceraTransaccion::findOrFail($id);
        $saldo = $data->saldo;
        $newSaldo = $saldo - $valor;
        CabeceraTransaccion::where('id', $id)->update([
            'saldo' => $newSaldo
        ]);
    }

    public function show($id)
    {
        $abonos = DetalleTransaccion::with([
            'pago', 'transaccion',
            'cabecera' => function ($q) {
                $q->with(['cotizacion' => function ($q) {
                }]);
            }
        ])->where('cabecera_id', $id)->get();

        $total = 0;

        foreach ($abonos as $abono) {
            $total = $total + $abono->valor;
        }

        $cuentas = CabeceraTransaccion::where('id', $id)->first();
        $saldo = $cuentas->saldo;

        return response()->json([
            'status' => 200,
            'abonos' => $abonos,
            'total' => $total,
            'saldo' => $saldo
        ]);
    }


    public function edit($id)
    {
        $formas = FormaPago::all();
        $transacciones = Transaccion::all();

        $cuentas = CabeceraTransaccion::with([
            'cotizacion' => function ($q) {
                $q->with(['usuario' => function ($q) {
                }]);
            }
        ])->where('id', $id)->first();

        return view('admin.cobros.view', compact('cuentas', 'formas', 'transacciones'));
        //return $cuentas;
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
