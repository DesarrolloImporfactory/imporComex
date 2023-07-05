<?php

namespace App\Http\Controllers;

use App\Models\Modalidades;
use App\Models\PuertoChina;
use Illuminate\Http\Request;
use App\Models\tipo_cargas;
use App\Models\tarifaGruapl;

class CargasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.cargas.index')->only('index');
        // $this->middleware('can:admin.cargas.store')->only('store');
        // $this->middleware('can:admin.cargas.update')->only('update');
        // $this->middleware('can:admin.cargas.destroy')->only('destroy');
    }

    public function index()
    {
        $carga = tipo_cargas::get();
        $tarifa = tarifaGruapl::get();
        $datos = [
            'cargas' => $carga,
            'tarifas' => $tarifa,
            'modalidades' => Modalidades::all(),
            'operaciones' => PuertoChina::all(),
        ];
        return view('admin.cargas.index', $datos);
    }

    public function storeTarifa(Request $request)
    {
        $data = new tarifaGruapl();

        $data->m3 = $request->input('m3');
        $data->vxcbm = $request->input('vxcbm');
        $data->tcbm = $request->input('tcbm');
        $data->valor_min = $request->input('valor_min');
        $data->valor_max = $request->input('valor_max');

        $data->save();
        return redirect('cargas')->with('mensaje', 'Tarifa Registrada');
    }

    public function store(Request $request)
    {
        $datosCarga = new tipo_cargas();
        $datosCarga->tipoCarga = $request->input('tipoCarga');
        $datosCarga->save();
        return redirect('cargas')->with('mensaje', 'Carga Registrada');
    }

    public function updateTarifa(Request $request, $id)
    {
        $datos = [
            "m3" => $request->input('m3'),
            "vxcbm" => $request->input('vxcbm'),
            "tcbm" => $request->input('tcbm'),
            "valor_min" => $request->input('valor_min'),
            "valor_max" => $request->input('valor_max')
        ];
        tarifaGruapl::whereid($id)->update($datos);
        return redirect('cargas')->with('mensaje', 'Tarifa Actualizada');
    }


    public function update(Request $request, $id)
    {
        $datos = array(
            "tipoCarga" => $request->input('tipoCarga')
        );
        tipo_cargas::whereid($id)->update($datos);
        return redirect('cargas')->with('mensaje', 'Carga Actualizada');
    }


    public function destroy($id)
    {
        tipo_cargas::destroy($id);
        return redirect('cargas')->with('mensaje', 'Carga Eliminada');
    }

    

   
}
