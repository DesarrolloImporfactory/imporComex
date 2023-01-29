<?php

namespace App\Http\Controllers;

use App\Models\ProductoInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CotizacionProductosController extends Controller
{
   
    public function index()
    {
        $productos = ProductoInsumo::all();

        return response()->json([
            'productos' => $productos
        ]);
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
            $producto = new ProductoInsumo();
            $producto->insumo_id = $request->input('insumo_id');
            $producto->cantidad = $request->input('cantidad');
            $producto->precio = $request->input('precio');
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
        //
    }

   
    public function edit($id)
    {
        //
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
