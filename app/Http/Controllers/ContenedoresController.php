<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenedores;
use App\Models\Cotizaciones;
use App\Models\Estado;
use App\Models\ContenedorCotizacion;
use Illuminate\Support\Facades\DB;


class ContenedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.contenedores.index')->only('index');
        // $this->middleware('can:admin.contenedores.store')->only('store');
        // $this->middleware('can:admin.contenedores.update')->only('update');
        // $this->middleware('can:admin.contenedores.destroy')->only('destroy');
    }

    public function index()
    {

        $contenedores = Contenedores::with('estado')->get();
        $estados = Estado::get();
        $query = "select count(*) as total, contenedores.id, contenedores.name as contenedor, estados.name, salida, llegada, tipo, latitud, longitud from contenedores, contenedor_cotizacions, estados where contenedores.id=contenedor_cotizacions.contenedor_id and contenedores.estado_id=estados.id group by contenedores.name,id, estados.name, salida, llegada, contenedores.tipo, latitud, longitud";
        $consulta = DB::select($query);

        $data = [
            'contenedores' => $contenedores,
            'estados' => $estados,
            'consulta' => $consulta
        ];

        return view('admin.contenedores.index',$data);
        //return $consulta;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'estado_id' => ['required'],

        ]);

        $datos = request()->except('_token');
        Contenedores::insert($datos);
        return redirect()->route('admin.contenedores.index')->with('mensaje','Contenedor Creado!');
    }



    public function update(Request $request, $id)
    {
        $datos = request()->except(['_token', '_method']);
        Contenedores::whereid($id)->update($datos);
        return redirect()->route('admin.contenedores.index')->with('mensaje','Contenedor Actualizado!');
    }


    public function destroy($id)
    {
        Contenedores::destroy($id);
        return redirect()->route('admin.contenedores.index')->with('mensaje','Contenedor Eliminado!');
    }
}
