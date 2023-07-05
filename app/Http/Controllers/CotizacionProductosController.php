<?php

namespace App\Http\Controllers;

use App\Models\Cotizaciones;
use App\Models\Divisa;
use App\Models\Insumo;
use App\Models\ProductoInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CotizacionProductosController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insumo_id' => 'required',
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
            'porcentaje' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {

            $productos = ProductoInsumo::where('cotizacion_id', $request->input('cotizacion_id'))->get();
            $baseFlete = $this->fleteBase($request->input('cotizacion_id'));
            $fob_antiguo = $request->input('total_fob');
            $fob = $request->input('cantidad') * $request->input('precio');
            $total_fob = $fob_antiguo + $fob;
            $seguro = $fob * 0.01;
            $flete = $fob * ($baseFlete / $total_fob);
            if (count($productos) > 0) {
                foreach ($productos as $producto) {
                    $flete_bucle = $producto->fob * ($baseFlete / $total_fob);
                    $cif_bucle = $flete_bucle + $producto->fob + $producto->seguro;
                    $adv_bucle = $cif_bucle * ($producto->porcentaje / 100);
                    $fodi_bucle = $cif_bucle * 0.005;
                    $iva_bucle = ($cif_bucle + $adv_bucle + $fodi_bucle) * (12 / 100);
                    $imp_bucle = $adv_bucle + $fodi_bucle + $iva_bucle;
                    ProductoInsumo::where('id', $producto->id)->update([
                        'flete' => $flete_bucle,
                        'cif' => $cif_bucle,
                        'advalorem' => $adv_bucle,
                        'fodinfa' => $fodi_bucle,
                        'iva' => $iva_bucle,
                        'impuestos' => $imp_bucle,
                        'total' => ($producto->cantidad * $producto->precio) + $imp_bucle
                    ]);
                }
            }

            $divisa = Divisa::first();

            $cif = $fob + $seguro + $flete;
            $advalorem = $cif * ($request->input('porcentaje') / 100);
            $fodinfa = $cif * 0.005;
            $iva = ($cif + $advalorem + $fodinfa) * (12 / 100);
            $Impuestos = $advalorem + $fodinfa + $iva;
            $producto = new ProductoInsumo();
            $producto->insumo_id = $request->input('insumo_id');
            $producto->cantidad = $request->input('cantidad');
            $producto->precio = $request->input('precio');
            $producto->fob = $fob;
            $producto->divisas = $fob * $divisa->tarifa;
            $producto->seguro = $seguro;
            $producto->flete = $flete;
            $producto->cif = $cif;
            $producto->advalorem = $advalorem;
            $producto->fodinfa = $fodinfa;
            $producto->iva = $iva;
            $producto->Impuestos = $Impuestos;
            $producto->total = ($request->input('cantidad') * $request->input('precio')) + $Impuestos;
            $producto->porcentaje = $request->input('porcentaje');
            $producto->cotizacion_id = $request->input('cotizacion_id');
            $producto->save();
            Insumo::where('id', $request->input('insumo_id'))->update([
                'porcentaje' => $request->input('porcentaje')
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Producto creado!',
            ]);
        }
    }

    public function fleteBase($id)
    {
        $cotizacion = Cotizaciones::findOrFail($id);
        $volumen = $cotizacion->volumen;
        if ($volumen < 1) {
            $fleteBase = 250;
            return $fleteBase;
        } else {
            $fleteBase = 250 * $volumen;
            return $fleteBase;
        }
    }

    public function show($id)
    {
        $productos = ProductoInsumo::with('insumo')->where('cotizacion_id', $id)->get();
        $totalProducto = 0;
        $totalFob = 0;
        $totalSeguro = 0;
        $totalFlete = 0;
        $totalCif = 0;
        $totalAdvalorem = 0;
        $totalFodinfa = 0;
        $totalIva = 0;
        $totalImpuestos = 0;
        $totalTotal = 0;
        foreach ($productos as $item) {
            $totalProducto = $totalProducto + $item->cantidad;
            $totalSeguro = $totalSeguro + $item->seguro;
            $totalFob = $totalFob + $item->fob;
            $totalFlete = $totalFlete + $item->flete;
            $totalCif = $totalCif + $item->cif;
            $totalIva = $totalIva + $item->iva;
            $totalImpuestos = $totalImpuestos + $item->Impuestos;
            $totalFodinfa = $totalFodinfa + $item->fodinfa;
            $totalAdvalorem = $totalAdvalorem + $item->advalorem;
            $totalTotal = $totalTotal + $item->total;
        }

        return response()->json([
            'totalProducto' => $totalProducto,
            'totalSeguro' => $totalSeguro,
            'totalFob' => $totalFob,
            'totalFlete' => $totalFlete,
            'totalCif' => $totalCif,
            'totalIva' => $totalIva,
            'totalImpuestos' => $totalImpuestos,
            'totalFodinfa' => $totalFodinfa,
            'totalAdvalorem' => $totalAdvalorem,
            'productos' => $productos,
            'totalTotal' => $totalTotal,
        ]);
    }


    public function edit($id)
    {
        $relacion = ProductoInsumo::find($id);
        if ($relacion) {
            return response()->json([
                'status' => 200,
                'relacion' => $relacion
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'El item seleccionado no existe'
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $datos = ProductoInsumo::find($id);
            ProductoInsumo::where('id', $id)->update([
                'cantidad' => $request->input('cantidad'),
                'precio' => $request->input('precio'),
                'porcentaje' => $request->input('porcentaje'),
            ]);
            $this->cotizador($datos->cotizacion_id);
            return response()->json([
                'status' => 200,
                'message' => 'Valor actualizado exitosamente!'
            ]);
        }
    }

    public function cotizador($cotizacion_id)
    {
        $productos = ProductoInsumo::where('cotizacion_id', $cotizacion_id)->get();
        if ($productos) {
            $baseFlete = $this->fleteBase($cotizacion_id);
            $fob_total = 0;
            foreach ($productos as $producto) {
                $fob_total = $fob_total + $producto->fob;
            }
            foreach ($productos as $product) {
                $fob = $product->precio * $product->cantidad;
                $seguro = $fob * 0.01;
                $flete_bucle = $product->fob * ($baseFlete / $fob_total);
                $cif_bucle = $flete_bucle + $product->fob + $product->seguro;
                $adv_bucle = $cif_bucle * ($product->porcentaje / 100);
                $fodi_bucle = $cif_bucle * 0.005;
                $iva_bucle = ($cif_bucle + $adv_bucle + $fodi_bucle) * (12 / 100);
                $imp_bucle = $adv_bucle + $fodi_bucle + $iva_bucle;
                ProductoInsumo::where('id', $product->id)->update([
                    'flete' => $flete_bucle,
                    'cif' => $cif_bucle,
                    'advalorem' => $adv_bucle,
                    'fodinfa' => $fodi_bucle,
                    'iva' => $iva_bucle,
                    'impuestos' => $imp_bucle,
                    'total' => ($product->cantidad * $product->precio) + $imp_bucle
                ]);
            }
        }
    }


    public function destroy($id)
    {
        $datos = ProductoInsumo::find($id);
        $cotizacion_id = $datos->cotizacion_id;
        ProductoInsumo::destroy($id);

        $this->cotizador($datos->cotizacion_id);

        return response()->json([
            'status' => 200,
            'message' => 'Seccion eliminada!'
        ]);
    }
}
