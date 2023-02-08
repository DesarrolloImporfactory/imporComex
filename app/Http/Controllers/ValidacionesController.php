<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Validacion;
use \Milon\Barcode\DNS1D;
use App\Models\Cotizaciones;
use App\Models\Contenedores;
use App\Models\Impuesto;
use App\Models\cotizacion_impuesto;
use App\Models\ProductoInsumo;
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
         if ($relacion == 1 ) {
            $cotizacion = Cotizaciones::whereid($cotizacion_id)->with(['validacions', 'modalidad', 'carga', 'pais', 'usuario','ciudad'])->first();
            $carbon = new \Carbon\Carbon();
            $productos = ProductoInsumo::wherecotizacion_id($cotizacion_id)->with('insumo')->get();
            $proveedores = Validacion::wherecotizacion_id($cotizacion_id)->get();
            $barcode = $cotizacion->barcode;
            $inBackground = true;
            return view('admin.calculadoras.indexPrint', compact(['cotizacion', 'carbon', 'barcode', 'productos', 'inBackground','proveedores']));
         } else {
            return redirect()->route('admin.colombia.edit', $cotizacion_id)->with('message', 'Completemos la cotizacion!');
         }
        
    }


    public function create()
    {
        return $data = "Vista Craete";
    }


    public function store(Request $request)
    {
        $cotizacion_id = $request->input('cotizacion_id');
        $validator = Validator::make($request->all(), [
            'impuestos' => 'required|numeric|min:1',
            'compra' => 'required|numeric|min:1',
        ]);
        //$relacion = Validacion::where('cotizacion_id', $cotizacion_id)->count();
        if ($validator->fails() ) {
            return redirect()->route('admin.colombia.edit', $cotizacion_id)->with('message','Por favor complete el proceso de cotizacion');
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

            $datos = [
                "proceso" => '3',
                "total_impuesto" => $request->input('impuestos'),
                "total_compra" => $request->input('compra'),
                "total" => $logistica + $request->input('impuestos') + $request->input('compra')
            ];

            Cotizaciones::whereid($cotizacion_id)->update($datos);
            DB::table('contenedor_cotizacions')->insert([
                'cotizacion_id' => $cotizacion_id,
                'contenedor_id' => $contenedor,
            ]);
            return redirect()->route('validacion.print', $cotizacion_id);
        }
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
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        $mensaje = "false";
        $data = [
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje
        ];
        return view('admin.calculadoras.colombia.grupal.formulario', $data);
    }



    public function update(Request $request, $id)
    {
        
    }


    public function destroy($id)
    {
        //
    }
}
