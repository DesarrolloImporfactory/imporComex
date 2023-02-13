<?php

namespace App\Http\Controllers;

use App\Models\ProductoInsumo;
use Illuminate\Http\Request;
use App\Models\Validacion;
use Illuminate\Support\Facades\Validator;

class ProveedoresController extends Controller
{


    public function create(Request $request)
    {
       
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->file(), [
            'foto'=>'required',
            'factura'=>'required',
        ]);
        $validar = Validator::make($request->all(), [
            'nombre_proveedor'=>'required',
            'cantidad_cartones'=>'required | numeric | min:1',
            'enlace'=>'required | url',
            'contacto'=>'required'
        ]);
        
        if ($validator->fails() || $validar->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
                'errores' => $validar->messages(),
            ]);
        }else{
            $proveedor = new Validacion();
            $proveedor->nombre_pro = $request->input('nombre_proveedor');
            $proveedor->total_cartones = $request->input('cantidad_cartones');
            $proveedor->factura = $request->file('factura')->store('docs', 'public');
            $proveedor->foto = $request->file('foto')->store('uploads', 'public');
            $proveedor->enlace = $request->input('enlace');
            $proveedor->contacto = $request->input('contacto');
            $proveedor->cotizacion_id = $request->input('cotizacion_id');
            $proveedor->save();
            return response()->json([
                'status' => 200,
                'message' => 'Proveedor creado!',
            ]);
        }
    }


    public function show($id)
    {
        $datos = Validacion::where('cotizacion_id',$id)->get();
        return response()->json([
            'status'=>200,
            'proveedores'=>$datos,
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function asignarProveedor(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'proveedor_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errores' => $validator->messages()
            ]);
        }else{
            $data = [
                'proveedor_id'=>$request->input('proveedor_id')
            ];
            ProductoInsumo::where('id',$id)->update($data);
            return response()->json([
                'status' => 200,
                'message' => 'Proveedor asignado!'
            ]);
        }
       
    }


    public function destroy($id)
    {
        Validacion::destroy($id);
        return response()->json([
            'status'=>200,
            'message'=>'Proveedor eliminado!'
        ]);
    }
}
