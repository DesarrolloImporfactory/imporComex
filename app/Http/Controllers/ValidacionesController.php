<?php

namespace App\Http\Controllers;

use App\Models\CabeceraTransaccion;
use App\Models\Comision;
use Illuminate\Http\Request;
use App\Models\Validacion;
use \Milon\Barcode\DNS1D;
use App\Models\Cotizaciones;
use App\Models\Contenedores;
use App\Models\Impuesto;
use App\Models\cotizacion_impuesto;
use App\Models\Divisa;
use App\Models\ProductoInsumo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class ValidacionesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:validacion.print')->only('print');
    //     $this->middleware('can:validacion.store')->only('store');

    // }

    public function print($cotizacion_id)
    {
        $relacion = ProductoInsumo::where('cotizacion_id', $cotizacion_id)->exists();
        //$validacion = Validacion::where('cotizacion_id', $cotizacion_id)->exists();
        if ($relacion == 1) {
            $cotizacion = Cotizaciones::whereid($cotizacion_id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario', 'ciudad'])->first();
            $carbon = new \Carbon\Carbon();
            $productos = ProductoInsumo::wherecotizacion_id($cotizacion_id)->with(['insumo', 'proveedor'])->get();
            $proveedores = Validacion::wherecotizacion_id($cotizacion_id)->get();
            $barcode = $cotizacion->barcode;
            $inBackground = true;

            return view('admin.calculadoras.indexPrint', compact(['cotizacion', 'carbon', 'barcode', 'productos', 'inBackground', 'proveedores']));
        } else {
            return redirect()->route('admin.colombia.edit', $cotizacion_id)->with('message', 'Completemos la cotizacion!');
        }
    }



    public function create()
    {
        return $data = "Vista Craete";
    }

    public function guardarProveedor(Request $request)
    {
        $cantidad = count($request->input('estado'));
        $contador = 0;
        for ($i = 1; $i <= $cantidad; $i++) {

            $validator = Validator::make($request->all(), [
                'nombre_pro' . $i => 'required',
                'enlace' . $i => 'required',
                'cartones' . $i => 'required',
                'contacto' . $i => 'required',
            ]);
            if ($validator->fails()) {
                $contador++;
            }
        }

        if ($contador == 0) {
            for ($i = 1; $i <= $cantidad; $i++) {
                if ($request->file('foto' . $i)) {
                    $foto = $request->file('foto' . $i)->store('docs', 'public');
                } else {
                    $foto = "null";
                }
                Validacion::create([
                    'nombre_pro' => $request->input('nombre_pro' . $i),
                    'contacto' => $request->input('contacto' . $i),
                    'enlace' => $request->input('enlace' . $i),
                    'total_cartones' => $request->input('cartones' . $i),
                    'foto' => $foto,
                    'cotizacion_id' => $request->input('cotizacion_id'),
                    'proveedores' => $request->input('proveedores'),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Proveedor creado!',
                'datos' => $request->all()
            ]);
        } else {
            return response()->json([
                'status' => 400,
            ]);
        }
    }


    public function store(Request $request)
    {
        $cotizacion_id = $request->input('cotizacion_id');
        $validator = Validator::make($request->all(), [
            'impuestos' => 'required|numeric|min:1',
            'compra' => 'required|numeric|min:1',
            'cantidad_productos' => 'required|numeric|min:1',
            'total_fob' => 'required|numeric|min:1',
        ]);
        //$relacion = Validacion::where('cotizacion_id', $cotizacion_id)->count();
        if ($validator->fails()) {
            return redirect()->route('admin.colombia.edit', $cotizacion_id)->with('message', 'Por favor complete el proceso de cotizacion');
        } else {

            //codigo para traer el contenedor mas recientemente creado con estado libre =1
            $data = Contenedores::whereestado_id(1)->latest('created_at')->first();
            if (isset($data)) {
                $contenedorNuevo = $data->id;
            }
            //codigo para traer el especialista con menor cantidad de cotizaciones asignadas
            $query = "
       select count(id) as cotizaciones, contenedor_id from contenedor_cotizacions group by contenedor_id";

            $consulta = DB::select($query);

            //condicion para saber si existe cotizaciones asignadas
            if (count($consulta) > 0) {
                $id = min($consulta);
                $idContenedorExistente = $id->contenedor_id;
                if ($contenedorNuevo != $idContenedorExistente) {
                    $contenedor = $contenedorNuevo;
                } else {
                    $contenedor = $idContenedorExistente;
                }
            } else {

                $contenedor = $contenedorNuevo;
            }

            $cotizacion = Cotizaciones::whereid($cotizacion_id)->first();
            $logistica = $cotizacion->total_logistica;
            $comision = $this->comision($request->input('total_fob'));
            $divisa = Divisa::first();
            $datos = [
                "proceso" => '3',
                "total_impuesto" => $request->input('impuestos'),
                "total_compra" => $request->input('compra'),
                "time" => Carbon::now(),
                "total_fob" => $request->input('total_fob'),
                "ISD" => $request->input('total_fob') * $divisa->tarifa,
                "cantidad_productos" => $request->input('cantidad_productos'),
                "comision" => $this->comision($request->input('total_fob')),
                "total" =>$comision + $request->input('total_fob') * $divisa->tarifa + $logistica + $request->input('impuestos') + $request->input('compra')
            ];

            Cotizaciones::whereid($cotizacion_id)->update($datos);
            DB::table('contenedor_cotizacions')->insert([
                'cotizacion_id' => $cotizacion_id,
                'contenedor_id' => $contenedor,
            ]);
            $saldo = $request->input('total_fob') * $divisa->tarifa + $logistica + $request->input('impuestos') + $request->input('compra');
            $this->cabecera($cotizacion_id, $saldo);
            return redirect()->route('validacion.print', $cotizacion_id);
        }
    }

    public function comision($fob)
    {
        $data = Comision::where('valor_min', '<', $fob)->where('valor_max', '>=', $fob)
            ->first();
        if (isset($data)) {
            $resultado = $data->valor;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }

    public function cabecera($id, $saldo)
    {
        $data = new CabeceraTransaccion();
        $data->cotizacion_id = $id;
        $data->fecha_cotizacion = Carbon::now();
        $data->estado = 0;
        $data->saldo = $saldo;
        $data->save();
    }

    public function guardar(Request $request, $id)
    {
        return $data = "Guardar";
    }

    public function editpaso2($data)
    {

        $validacion = Validacion::wherecotizacion_id($data)->first();
        $validaciones = Validacion::wherecotizacion_id($data)->get();
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad', 'validacions'])->first();
        if (count($validaciones) > 0) {
            $datos = [
                'validacion' => $validacion,
                'cotizacion' => $cotizacion,
                'validaciones' => $validaciones
            ];
            return view('admin.paso2.edit', $datos);
        } else {
            return redirect()->route('admin.colombia.edit', $data)->with('mensaje', 'Completemos la cotizacion!');
        }
    }

    public function edit($data)
    {
        // $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        // $mensaje = "false";
        // $data = [
        //     'cotizacion' => $cotizacion,
        //     'mensaje' => $mensaje
        // ];
        // return view('admin.calculadoras.colombia.grupal.formulario', $data);
    }

    public function updateFlete(Request $request, $id)
    {
        Cotizaciones::where('id', $id)->update([
            'flete_maritimo' => $request->input('flete'),
            'gastos_origen' => $request->input('gastos'),
            'total_logistica' => $request->input('flete') + $request->input('gastos')
        ]);
        return redirect()->route('admin.colombia.edit', $id)->with('message', 'Flete modificado!');
    }

    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
        //
    }
}
