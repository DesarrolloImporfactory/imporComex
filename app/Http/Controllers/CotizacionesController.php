<?php

namespace App\Http\Controllers;

use App\Models\ContenedorCotizacion;
use App\Models\Contenedores;
use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\User;
use App\Models\Validacion;
use App\Models\CoIndividual;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class CotizacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.cotizaciones.show')->only('show');
        // $this->middleware('can:admin.cotizaciones.destroy')->only('destroy');

    }

    public function index()
    {
        $cotizaciones = Cotizaciones::get();
        return view('admin.cotizaciones.index', compact('cotizaciones'));
    }


    public function create()
    {
    }

    //funciona para cotizacion individual
    public function store(Request $request)
    {
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
            $cotizacionIndividual = CoIndividual::with(['origen', 'destino', 'incoter', 'usuario', 'especialista'])->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else if ($usuario == "Especialista") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereespecialista_id($id)->get();
            $cotizacionIndividual = CoIndividual::with(['origen', 'destino', 'incoter', 'usuario', 'especialista'])->whereespecialista_id($id)->get();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereusuario_id($id)->get();
            $cotizacionIndividual = CoIndividual::with(['origen', 'destino', 'incoter', 'usuario', 'especialista'])->whereusuario_id($id)->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        }

        $data = [
            'cotizacionIndividual'=>$cotizacionIndividual,
            'listadoCotizaciones' => $listadoCotizaciones,
            'cotizaciones' => $cotizaciones,
            'aprobadas' => $cotizacionesAprobadas,
            'pendientes' => $cotizacionesPendientes
        ];
        return view('admin.cotizaciones.index', $data);
        //return $data;
    }


    public function edit($id)
    {
        $proveedor = Validacion::where('cotizacion_id', $id)->get();
        $cotizacion = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereid($id)->first();
        $contenedor_cotizacion = ContenedorCotizacion::wherecotizacion_id($id)->first();

        if (isset($contenedor_cotizacion)) {
            $idRelacion = $contenedor_cotizacion->contenedor_id;
            $contenedor = Contenedores::with('estado')->whereid($idRelacion)->first();
            $dato=1;
            return view('admin.cotizaciones.view', compact('cotizacion','proveedor','contenedor','dato'));
        } else {
            $dato = 0;
            return view('admin.cotizaciones.view', compact('cotizacion','proveedor','dato'));
        }

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function cotizacionesAprobadas($id){
        $usuarioRol = User::with('roles')->findOrFail($id);
        foreach ($usuarioRol->roles as $rol) {
            $usuario = $rol->name;
        }

        if ($usuario == "Admin") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereestado('aprobado')->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else if ($usuario == "Especialista") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereespecialista_id($id)->whereestado('aprobado')->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereusuario_id($id)->whereestado('aprobado')->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        }

        $data = [
            'listadoCotizaciones' => $listadoCotizaciones,
            'cotizaciones' => $cotizaciones,
            'aprobadas' => $cotizacionesAprobadas,
            'pendientes' => $cotizacionesPendientes
        ];
        return view('admin.cotizaciones.viewAprov', $data);
    }

    public function destroy($id)
    {

        Cotizaciones::destroy($id);
        $user = Auth::user()->id;
        return redirect()->route('admin.cotizaciones.show', $user)->with('mensaje', 'Cotizacion Eliminada');
    }
}
