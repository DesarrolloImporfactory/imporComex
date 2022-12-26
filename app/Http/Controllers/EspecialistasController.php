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
        //$cotizaciones = Cotizaciones::count();
        return  rand(1,8);
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
            $usuario=$rol->name;
        }
        if ($usuario=="Admin") {
            $listadoCotizaciones = Cotizaciones::with(['modalidad','pais','carga','usuario','especialista','contenedor'])->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas=Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes=Cotizaciones::whereestado('pendiente')->count();
        
        } else {
            $listadoCotizaciones = Cotizaciones::with(['modalidad','pais','carga','usuario','especialista','contenedor'])->whereid($id)->get();
            $cotizaciones = Cotizaciones::count();
            $cotizacionesAprobadas=Cotizaciones::whereestado('aprobado')->count();
            $cotizacionesPendientes=Cotizaciones::whereestado('pendiente')->count();
        }

        $data=[
            'listadoCotizaciones'=>$listadoCotizaciones,
            'cotizaciones'=>$cotizaciones,
            'cotizacionesAprobadas'=>$cotizacionesAprobadas,
            'cotizacionesPendientes'=>$cotizacionesPendientes
        ];
        return view('admin.especialistas.index',$data);
        
    }

   
    public function edit($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        $datos = array(
            "estado"=>$request->input('estado')
        );
        Cotizaciones::whereid($id)->update($datos);
        return redirect('admin/especialistas')->with('mensaje','Modalid Actualizada');
    }

    
    public function destroy($id)
    {
        //
    }
}
