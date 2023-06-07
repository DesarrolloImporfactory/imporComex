<?php

namespace App\Http\Controllers\Fcl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Cotizaciones;
use App\Mail\EmailEspecialista;
use App\Models\User;
use App\Models\Ciudad;
use App\Models\Variables;
use App\Models\Categoria;
use App\Models\Insumo;
use App\Models\Tarifario;
use Illuminate\Support\Facades\DB;

class ContenedorCompletoController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        if ($request->input('existe')) {
            $request->validate([
                'cliente' => ['required'],
                'inflamable' => ['required'],
                'peso' => ['required',],
                'cargas_id' => ['required'],
                'tiene_bateria' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'liquidos' => ['required'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:1', 'numeric:0'],
                'puerto_id' => ['required'],
                'ciudad_entrega' => ['required'],
            ]);
        } else {
            $request->validate([
                'inflamable' => ['required'],
                'peso' => ['required',],
                'cargas_id' => ['required'],
                'tiene_bateria' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'liquidos' => ['required'],
                'direccion' => ['required', 'string', 'min:5'],
                'puerto_id' => ['required'],
                'volumen' => ['required', 'min:1', 'numeric:0'],
                'ciudad_entrega' => ['required'],
            ]);
        }

        if ($request->input('cliente')) {

            $cliente = $request->input('cliente');
        } else {
            $cliente = $request->input('usuario_id');
        }

        $grupal = new Cotizaciones();


        $barcode = IdGenerator::generate(['table' => 'cotizaciones', 'field' => 'barcode', 'length' => 6, 'prefix' => date('y')]);

        //codigo para traer el ultimo especialista creado dentro de User
        $data = User::latest('created_at')->whereHas("roles", function ($q) {
            $q->where("name", "Especialista");
        })->first();

        if (isset($data)) {
            $idEspecialistaNuevo = $data->id;
        }

        //codigo para traer el especialista con menor cantidad de cotizaciones asignadas
        $query = "Select count(id) as cotizaciones, especialista_id from cotizaciones where estado='aprobado' or estado='pendiente' group by especialista_id";

        $consulta = DB::connection('imporcomex')->select($query);
        //condicion para saber si existe cotizaciones asignadas
        if (count($consulta) > 0) {

            $id = min($consulta);

            $idEspecialistaExistente = $id->especialista_id;
            if ($idEspecialistaNuevo != $idEspecialistaExistente) {
                $especialista = $idEspecialistaNuevo;
            } else {
                $especialista = $idEspecialistaExistente;
            }
        } else {

            $especialista = $idEspecialistaNuevo;
        }
        ////Envio de correo electronico al especialista
        $datosEspecialista = User::findOrFail($especialista);
        $emailEsp = $datosEspecialista->email;
        //$correo = new EmailEspecialista;
        Mail::to($emailEsp)->send(new EmailEspecialista($cliente));
        /// fin de correo
        $proveedores = $request->input('cantidad_proveedores');

        $grupal->barcode = $barcode;
        $peso = $request->input('peso');
        $grupal->usuario_id = $cliente;
        $grupal->pais_id = $request->input('pais');
        $grupal->modalidad_id = $request->input('modalidad');
        $grupal->inflamable = $request->input('inflamable');
        $grupal->peso = $peso;
        $grupal->estado = "Pendiente";
        $grupal->time = Carbon::now();
        $grupal->origen = $request->input('origen');
        $grupal->puerto_id = $request->input('puerto_id');
        $grupal->tiene_bateria = $request->input('tiene_bateria');
        $grupal->liquidos = $request->input('liquidos');
        $grupal->cargas_id = $request->input('cargas_id');
        $grupal->direccion = $request->input('direccion');
        $grupal->cantidad_proveedores = $request->input('cantidad_proveedores');
        $grupal->especialista_id = $especialista;
        $grupal->tarifa_id = $request->input('ciudad_entrega');
        $grupal->proceso = '2';
        $gastos_origen = $this->gastosOrigen();
        $grupal->gastos_origen = $gastos_origen;
        $grupal->flete_maritimo = $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso'));
        $grupal->flete = $request->input('volumen');
        $collect = $request->input('volumen') * 0.05;
        $gastosLocales = $this->fclocal($collect) + ($this->fclocal($collect) * 0.12);
        $grupal->gastos_local = $gastosLocales;
        $otrosGastos = $this->otrosGastosFcl($request->input('ciudad_entrega'), $request->input('peso'));
        $grupal->otros_gastos = $otrosGastos;
        $grupal->total_logistica = $otrosGastos + $request->input('volumen') + $gastos_origen + $gastosLocales;

        $grupal->save();
        $data = Cotizaciones::latest('id')->first();
        return redirect()->route('contenedorCompleto.edit', $data);
    }
    public function ciudadEntrega($ciudadEntrega, $peso)
    {
        $ciudad = Tarifario::findOrFail($ciudadEntrega);
        $destino = $ciudad->destino;
        $transporte = $ciudad->transporte;
        $tarifas = Tarifario::where('transporte', $transporte)->where('destino', $destino)->get();
        $pesoTonelada = $peso / 1000;
        foreach ($tarifas as $tarifa) {
            if ($pesoTonelada >= $tarifa->peso_min && $pesoTonelada <= $tarifa->peso_max) {
                return $costo = $tarifa->costo;
            } else {
                return $costo = 0;
            }
        }
    }
    public function otrosGastosFcl($ciudadEntrega, $peso)
    {
        $agente = Variables::findOrFail(8);
        $bodegaje = Variables::findOrFail(9);
        $ciudad = Tarifario::findOrFail($ciudadEntrega);
        $destino = $ciudad->destino;
        $transporte = $ciudad->transporte;
        $tarifas = Tarifario::where('transporte', $transporte)->where('destino', $destino)->get();
        $pesoTonelada = $peso / 1000;
        foreach ($tarifas as $tarifa) {
            if ($pesoTonelada >= $tarifa->peso_min && $pesoTonelada <= $tarifa->peso_max) {
                $costo = $tarifa->costo;
            } else {
                $costo = 0;
            }
        }
        $total = ($agente->valor * 1.12) + $costo + $bodegaje->minimo;
        return $total;
    }
    public function fclocal($collect)
    {
        $tasa = Variables::findOrFail(10);
        $transmicion = Variables::findOrFail(5);
        return $tasa->valor + $transmicion->minimo + $collect;
    }

    public function naviera($volumen)
    {
        $tasa = Variables::findOrFail(1);
        $tasaValor = $tasa->valor;
        $total = $tasaValor * $volumen;
        return $total;
    }
    public function gastosOrigen()
    {
        $baf = Variables::findOrFail(2);
        $aduana = Variables::findOrFail(3);
        $bafValor = $baf->valor;
        $aduanaValor = $aduana->valor;
        $total_gastos_origen = $bafValor + $aduanaValor;
        return $total_gastos_origen;
    }

    public function gastosLocales($volumen)
    {

        $transmicion = Variables::findOrFail(5);
        $locales = Variables::findOrFail(10);

        $collect = $volumen * 0.05;
        $suma = $transmicion->valor + $locales->valor + $collect;
        $total = ($suma + ($suma * 0.12));
        return $total;
    }

    public function otrosGastos($ciudadEntrega, $peso)
    {
        $agente = Variables::findOrFail(8);
        $bodegaje = Variables::findOrFail(9);
        $ciudad = Ciudad::findOrFail($ciudadEntrega);
        $provincia = $ciudad->provincia;
        $tarifa = $ciudad->tarifa;
        $kilo = $ciudad->kilo_adicional;

        if ($provincia == "PICHINCHA") {
            $costo = 10;
        } else if ($provincia == "GUAYAS") {
            $tipo = $ciudad->tipo_trayecto;
            if ($tipo != "ESPECIAL") {
                $costo = 10;
            } else {
                $costo = $tarifa + ($kilo * $peso);
            }
        } else {
            $costo = $tarifa + ($kilo * $peso);
        }
        $total = ($agente->valor * 1.12) + $costo + $bodegaje->valor;
        return $total;
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $variables = Variables::findOrFail(9);
        $cotizacion = Cotizaciones::whereid($id)->with(['carga', 'pais', 'modalidad'])->first();
        $mensaje = "true";
        $data = [
            'categoria' => $categoria,
            'insumo' => $insumo,
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje,
            'variables' => $variables
        ];
        return view('admin.calculadoras.colombia.maestroAjax', $data);
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
