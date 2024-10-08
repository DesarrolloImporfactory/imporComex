<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\User;
use App\Models\Validacion;
use Spatie\Permission\Models\Role;

class EspecialistasController extends Controller
{
    public function __construct()
    {

        $this->middleware('can:admin.especialistas.show')->only('show');
        // $this->middleware('can:admin.especialistas.edit')->only('edit');
        // $this->middleware('can:admin.especialistas.update')->only('update');
    }

    public function index()
    {
    }

    public function count()
    {
        $cotizaciones = Cotizaciones::count();
        return  response()->json($cotizaciones);
    }

    public function dowloadFoto($id)
    {
        $proveedor = Validacion::where('id', $id)->first();
        $foto = $proveedor->foto;
        $archivo = storage_path('app/public/' . $foto);
        return response()->download($archivo);
        //return $archivo;
    }

    public function dowloadArchivo($id)
    {
        $proveedor = Validacion::where('id', $id)->first();
        $foto = $proveedor->factura;
        $archivo = storage_path('app/public/' . $foto);
        return response()->download($archivo);
        //return $archivo;
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $usuarioRol = User::with('roles')->findOrFail($id);
        //foreach para mapear la consulta anidada
        foreach ($usuarioRol->roles as $rol) {
            $usuario = $rol->name;
        }
        if ($usuario == "Admin") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista','ciudad'])->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else if ($usuario == "Especialista") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista','ciudad'])->whereespecialista_id($id)->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista','ciudad'])->whereusuario_id($id)->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        }

        $data = [
            'listadoCotizaciones' => $listadoCotizaciones,
            'cotizaciones' => $cotizaciones,
            'cotizacionesAprobadas' => $cotizacionesAprobadas,
            'cotizacionesPendientes' => $cotizacionesPendientes
        ];
        return view('admin.especialistas.index', $data);
    }


    public function edit($id)
    {
        $existe = Validacion::where('cotizacion_id', $id)->exists();
        if ($existe == 1) {
            $proveedor = Validacion::where('cotizacion_id', $id)->get();
            $proveedores = Validacion::where('cotizacion_id', $id)->first();
        } else {
            $proveedor = 'false';
            $proveedores = 'false';
        }

        $cotizacion = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista','ciudad'])->whereid($id)->first();
        //return $proveedor;
        return view('admin.especialistas.view', compact('cotizacion', 'proveedor', 'proveedores'));
    }


    public function update(Request $request, $idCotiz)
    {
        $datos = array(
            "estado" => $request->input('estado')
        );
        Cotizaciones::whereid($idCotiz)->update($datos);
        $usuario = Cotizaciones::findOrFail($idCotiz);
        $id = $usuario->usuario_id;
        return redirect()->route('admin.especialistas.show', $id)->with('mensaje', 'Estado Actualizado');
        //return $idCotiz;
    }


    public function destroy($id)
    {
        //
    }
}
