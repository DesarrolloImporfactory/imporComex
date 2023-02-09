<?php

namespace App\Http\Controllers;

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
            $fob = $request->input('cantidad') * $request->input('precio');
            $seguro = $fob * 0.01;
            $flete = $fob / 5;
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
            return response()->json([
                'status' => 200,
                'message' => 'Producto creado!',
            ]);
        }
    }


    public function show($id)
    {
        $productos = ProductoInsumo::with('insumo')->where('cotizacion_id', $id)->get();
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
            $totalSeguro = $totalSeguro + $item->seguro;
            $totalFob = $totalFob + $item->fob;
            $totalFlete = $totalFlete + $item->flete;
            $totalCif = $totalCif + $item->cif;
            $totalIva = $totalIva + $item->iva;
            $totalImpuestos = $totalImpuestos + $item->impuestos;
            $totalFodinfa = $totalFodinfa + $item->fodinfa;
            $totalAdvalorem = $totalAdvalorem + $item->advalorem;
            $totalTotal = $totalTotal + $item->total;
        }

        return response()->json([
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
            if ($datos) {

                $fob = $request->input('cantidad') * $request->input('precio');
                $seguro = $fob * 0.01;
                $flete = $fob / 5;
                $cif = $fob + $seguro + $flete;
                $advalorem = $cif * ($request->input('cantidad') / 100);
                $fodinfa = $cif * 0.005;
                $iva = ($cif + $advalorem + $fodinfa) * (12 / 100);
                $Impuestos = $advalorem + $fodinfa + $iva;

                $datos->cantidad = $request->input('cantidad');
                $datos->precio = $request->input('precio');
                $datos->fob = $fob;
                $datos->seguro = $seguro;
                $datos->flete = $flete;
                $datos->cif = $cif;
                $datos->advalorem = $advalorem;
                $datos->fodinfa = $fodinfa;
                $datos->iva = $iva;
                $datos->impuestos = $Impuestos;
                $datos->total = ($request->input('cantidad') * $request->input('precio')) + $Impuestos;
                $datos->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Valor actualizado exitosamente!'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'El valore seleccionado no existe'
                ]);
            }
        }
    }


    public function destroy($id)
    {
        ProductoInsumo::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Seccion eliminada!'
        ]);
    }
}
