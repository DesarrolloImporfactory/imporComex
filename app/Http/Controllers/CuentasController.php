<?php

namespace App\Http\Controllers;

use App\Models\CabeceraTransaccion;
use App\Models\DetalleTransaccion;
use App\Models\FormaPago;
use App\Models\Transaccion;
use App\Notifications\SaldoNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class CuentasController extends Controller
{

    public function index()
    {
        return view('admin.cobros.index');
    }


    public function create()
    {
        $cuentas = CabeceraTransaccion::join('cotizaciones', 'cotizaciones.id', '=', 'cabecera_transaccions.cotizacion_id')
            ->join('users', 'users.id', '=', 'cotizaciones.usuario_id')
            ->select('cabecera_transaccions.id', 'cabecera_transaccions.cotizacion_id', 'users.name', 'cabecera_transaccions.fecha_cotizacion', 'cabecera_transaccions.estado', 'cotizaciones.total', 'cabecera_transaccions.saldo')->get();

        return DataTables::of($cuentas)
            ->editColumn('estado', function ($cuentas) {
                if ($cuentas->estado == 0) {
                    return '<span class="badge rounded-pill text-bg-danger">Pendiente</span>';
                } else {
                    return '<span class="badge rounded-pill text-bg-success">Pagado</span>';
                }
            })
            ->addColumn('action', function ($cuenta) {
                return '<a class="" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-bars"></i></a><ul class="dropdown-menu">
                <li><a class="dropdown-item edit" value="' . $cuenta->cotizacion_id . '" href="#"><i class="bi bi-pencil-square"></i>Editar</a></li>
                <li>
                    <a class="dropdown-item abonos" value="' . $cuenta->id . '" href=""><i class="fa-solid fa-wallet"></i> Abonos</a>
                </li>
                <li>
                    <a class="dropdown-item notificar" value="' . $cuenta->id . '" href=""><i class="fa-regular fa-envelope"></i> Notificar</a>
                </li>
            </ul>';
            })->rawColumns(['action', 'estado'])->make(true);
    }

    public function notificar($id)
    {
        $data = User::findOrFail($id);

        $cuentas = CabeceraTransaccion::with([
            'cotizacion' => function ($q) {
                $q->with(['usuario' => function ($q) {
                }]);
            }
        ])->where('id', $id)->first();
        $email = $cuentas->cotizacion->usuario->email;
        Notification::route('mail', $email)->notify(new SaldoNotification($id));
        return response()->json([
            'mensaje' => 'Email Enviado con exito!'
        ]);
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
        if ($newSaldo <= 0) {
            $estado = 1;
        }else
        {
            $estado = 0;
        }
        CabeceraTransaccion::where('id', $id)->update([
            'saldo' => $newSaldo,
            'estado' =>$estado
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

    public function editAbono($id)
    {
        $abono = DetalleTransaccion::with([
            'pago', 'transaccion',
            'cabecera' => function ($q) {
                $q->with(['cotizacion' => function ($q) {
                }]);
            }
        ])->findOrFail($id);
        return response()->json([
            'status' => 200,
            'abono' => $abono
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
        $validator = Validator::make($request->all(), [
            'edit_valor' => 'required | numeric',
            'edit_pago' => 'required ',
            'edit_transaccion' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $this->newSaldo($id, $request->input('edit_valor'));
            DetalleTransaccion::where('id', $id)->update([
                'pago_id' => $request->input('edit_pago'),
                'transaccion_id' => $request->input('edit_transaccion'),
                'valor' => $request->input('edit_valor')
            ]);
            
            return response()->json([
                'status' => 200,
                'mensaje' => 'Abono Actualizado exitosamente!'
            ]);
        }
    }
    public function newSaldo($id, $valore)
    {
        $abono = DetalleTransaccion::findOrFail($id);
        $id_cabecera = $abono->cabecera_id;
        $valorOld = $abono->valor;

        $data = CabeceraTransaccion::findOrFail($id_cabecera);
        $saldo = $data->saldo;

        $newSaldo = ($saldo + $valorOld)-$valore;
        if ($newSaldo <= 0) {
            $estado = 1;
        }else
        {
            $estado = 0;
        }
         CabeceraTransaccion::where('id', $id_cabecera)->update([
             'saldo' => $newSaldo,
             'estado' => $estado
         ]);
        //return ("valor antiguo".$valorOld. "/ saldo :".$saldo. "/valor nuevo: ".$valore."/ nuevosaldo = ".$newSaldo);
    }

    public function destroy($id)
    {
        //
    }
}
