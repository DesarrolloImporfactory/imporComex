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

            $productos = ProductoInsumo::with('insumo')->where('cotizacion_id', $request->input('cotizacion_id'))->get();
            $baseFlete = $this->fleteBase($request->input('cotizacion_id'));
            $fob_antiguo = $request->input('total_fob');
            $fob = $request->input('cantidad') * $request->input('precio');
            $total_fob = $fob_antiguo + $fob;
            $seguro = ($fob * 1)/100;
            $fleteNuevo = $this->fleteNuevo($request->input('cotizacion_id'));
            if (count($productos) > 0) {
                
                foreach ($productos as $producto) {
                    $flete_bucle = $fleteNuevo/($productos->count()+1);
                    $cif_bucle = $flete_bucle + $producto->fob + $producto->seguro;
                    $adv_bucle = (($producto->fob + $producto->seguro) * ($producto->porcentaje))/100;
                    $fodi_bucle = ($cif_bucle * 0.5)/100;
                    $iva_bucle = (($cif_bucle + $adv_bucle + $fodi_bucle) * (12))/100;
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

            $cif = $fob + $seguro + ($this->fleteNuevo($request->input('cotizacion_id'))/($productos->count()+1));
            $advalorem = (($fob + $seguro)* ($request->input('porcentaje'))/100);
            $fodinfa = ($cif * 0.5)/100;
            $iva = (($cif + $advalorem + $fodinfa) * (12))/100;
            $Impuestos = $advalorem + $fodinfa + $iva;
            $producto = new ProductoInsumo();
            $producto->insumo_id = $request->input('insumo_id');
            $producto->cantidad = $request->input('cantidad');
            $producto->precio = $request->input('precio');
            $producto->fob = $fob;
            $producto->divisas = $fob * $divisa->tarifa;
            $producto->seguro = $seguro;
            $producto->flete = $this->fleteNuevo($request->input('cotizacion_id'))/($productos->count()+1);
            $producto->cif = $cif;
            $producto->advalorem = $advalorem;
            $producto->fodinfa = $fodinfa;
            $producto->iva = $iva;
            $producto->Impuestos = $advalorem + $fodinfa + $iva;
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

    public function fleteNuevo($id)
    {
        $cotizacion = Cotizaciones::findOrFail($id);
        if ($cotizacion->modalidad_id == '4') {
            return $cotizacion->flete;
        } else {
            return $cotizacion->flete_maritimo;
        }
    }

    public function show($id)
    {
        $productos = ProductoInsumo::with('insumo')->where('cotizacion_id', $id)->get();
        
        return response()->json([
            'totalProducto' => $productos->sum('cantidad'),
            'totalSeguro' => $productos->sum('seguro'),
            'totalFob' => $productos->sum('fob'),
            'totalFlete' => $productos->sum('flete'),
            'totalCif' => $productos->sum('cif'),
            'totalIva' => $productos->sum('iva'),
            'totalImpuestos' => $productos->sum('Impuestos') + $productos->sum('insumo.total'),
            'totalFodinfa' => $productos->sum('fodinfa'),
            'totalAdvalorem' => $productos->sum('advalorem'),
            'productos' => $productos,
            'totalTotal' => $productos->sum('total'),
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
        $fleteNuevo = $this->fleteNuevo($cotizacion_id);
        if ($productos) {
            $fob_total = 0;
            foreach ($productos as $producto) {
                $fob_total = $fob_total + $producto->fob;
            }
            foreach ($productos as $product) {
                $fob = $product->precio * $product->cantidad;
                $seguro = ($fob * 1)/100;
                $flete_bucle = $fleteNuevo/($productos->count());
                $cif_bucle = $flete_bucle + $product->fob + $product->seguro;
                $adv_bucle = (($product->fob + $product->seguro) * ($product->porcentaje))/100;
                $fodi_bucle = ($cif_bucle * 0.5)/100;
                $iva_bucle = (($cif_bucle + $adv_bucle + $fodi_bucle) * (12))/100;
                $imp_bucle = $adv_bucle + $fodi_bucle + $iva_bucle;
                ProductoInsumo::where('id', $product->id)->update([
                    'flete' =>$flete_bucle,
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
