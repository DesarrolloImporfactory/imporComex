<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\User;
use Spatie\Permission\Models\Role;

class EspecialistasController extends Controller
{

    public function index()
    {
    }

    public function count()
    {
        $cotizaciones = Cotizaciones::count();
        return  response()->json($cotizaciones);
    }

    public function create()
    {
        //
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
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereid($id)->get();
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
        $cotizacion = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereid($id)->first();
        //return $cotizacion;
        return view('admin.especialistas.view', compact('cotizacion'));
    }


    public function update(Request $request, $idCotiz)
    {
        
        $datos = array(
            "estado" => $request->input('estado')
        );
        Cotizaciones::whereid($idCotiz)->update($datos);
        $usuario = Cotizaciones::findOrFail($idCotiz);
        $id = $usuario->usuario_id;
        return redirect()->route('admin.especialistas.show', $id)->with('mensaje', 'Modalid Actualizada');
        //return $idCotiz;
    }


    public function destroy($id)
    {
        //
    }
}
