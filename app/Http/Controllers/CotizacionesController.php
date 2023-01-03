<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizaciones;
use App\Models\User;
use App\Models\Validacion;
use App\Models\Incoterm;
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
        return view('admin.cotizaciones.index',compact('cotizaciones'));
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
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        } else if($usuario == "Especialista") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereespecialista_id($id)->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas = Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes = Cotizaciones::whereestado('pendiente')->count();
        }else{
            $listadoCotizaciones = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereusuario_id($id)->get();
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
        return view('admin.cotizaciones.index', $data);
        //return $data;
    }

  
    public function edit($id)
    {
        $proveedor = Validacion :: where('cotizacion_id',$id)->get();
        $cotizacion = Cotizaciones::with(['modalidad', 'pais', 'carga', 'usuario', 'especialista'])->whereid($id)->first();
        //return $proveedor;
        return view('admin.cotizaciones.view', compact('cotizacion','proveedor'));
    }

    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {

        Cotizaciones::destroy($id);
        $user=Auth::user()->id;
        return redirect()->route('admin.cotizaciones.show', $user)->with('mensaje', 'Cotizacion Eliminada');
    }
}
