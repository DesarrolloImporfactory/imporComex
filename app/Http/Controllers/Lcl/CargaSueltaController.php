<?php

namespace App\Http\Controllers\Lcl;

use App\Http\Controllers\Controller;
use App\Models\Cotizaciones;
use Illuminate\Http\Request;
use App\Models\CalculadoraTemporal;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailEspecialista;
use App\Models\Calculadora;
use App\Models\Ciudad;
use App\Models\Variables;
use App\Models\Categoria;
use App\Models\Gasto;
use App\Models\Insumo;

class CargaSueltaController extends Controller
{

    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        // return $request->all();
        if ($request->input('existe')) {
            $request->validate([
                'cliente' => ['required'],
                'tipo_carga' => ['required'],
                'peso' => ['required',],
                'termino' => ['required'],
                'cargas_id' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:0.1', 'max:15', 'numeric'],
                'ciudad_entrega' => ['required'],
            ]);
        } else {
            $request->validate([
                'tipo_carga' => ['required'],
                'peso' => ['required',],
                'termino' => ['required'],
                'cargas_id' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:0.1', 'max:15', 'numeric'],
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
        $grupal->pais = $request->input('pais');
        $grupal->modalidad_id = $request->input('modalidad');
        $grupal->tipo_carga = $request->input('tipo_carga');
        $grupal->peso = $peso;
        $grupal->estado = "Pendiente";
        $grupal->time = Carbon::now();
        $grupal->origen = $request->input('origen');
        $grupal->incoterms_id = $request->input('puerto');
        $grupal->cargas_id = $request->input('cargas_id');
        $grupal->direccion = $request->input('direccion');
        $grupal->cantidad_proveedores = $request->input('cantidad_proveedores');
        $grupal->especialista_id = $especialista;
        $grupal->volumen = $request->input('volumen');
        $grupal->ciudad_id = $request->input('ciudad_entrega');
        $grupal->proceso = '2';
        $gastos_origen = $this->gastosOrigen($request->input('modalidad'), $request->input('termino'));
        $grupal->gastos_origen = $gastos_origen;
        $fleteMaritimo = $this->naviera($request->input('volumen'), $request->input('modalidad'), $request->input('termino'));
        $grupal->flete_maritimo = $fleteMaritimo;
        $flete =  $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso'));
        $grupal->flete =  $flete;
        $collect = $this->collect($fleteMaritimo, $request->input('modalidad'), $request->input('termino'));
        $grupal->collect =  $collect;
        $totalPagar = ($this->gastosLocales($request->input('volumen'), $request->input('modalidad'), $request->input('termino'))) + $collect;
        $grupal->gastos_sin_iva = $totalPagar;
        $gastosLocales = ($totalPagar + ($totalPagar * 0.12));
        $grupal->gastos_local = $gastosLocales;
        $otrosGastos = $this->otrosGastos($flete, $request->input('modalidad'), $request->input('termino'));
        $grupal->otros_gastos = $otrosGastos;
        $grupal->total_logistica = $otrosGastos + $fleteMaritimo + $gastosLocales + $gastos_origen;

        $grupal->save();
        $data =  $grupal->id;
        $this->productos($data);
        return redirect()->route('cargaSuelta.show', $data);
    }

    public function collect($flete, $modalidad, $termino)
    {
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'COLLECT FEE')
            ->where('operacion_id', $termino)->first();
        if (isset($variables)) {
            $total = $flete * $variables->valor;
            if ($total <= $variables->minimo) {
                $total = $variables->minimo;
            } 
            return $total;
        } else {
            return 0;
        }
    }

    public function productos($id)
    {
        $calculos = CalculadoraTemporal::where('usuario_id', auth()->user()->id)->get();
        foreach ($calculos as $calculo) {
            Calculadora::create([
                'cotizacion_id' => $id,
                'insumo_id' => $calculo->insumo_id,
                'cartones' => $calculo->cartones,
                'largo' => $calculo->largo,
                'ancho' => $calculo->ancho,
                'alto' => $calculo->alto,
                'total' => $calculo->total,
            ]);
        }
        CalculadoraTemporal::where('usuario_id', auth()->user()->id)->delete();
        return true;
    }

    public function ciudadEntrega($ciudadEntrega, $peso)
    {
        $ciudad = Ciudad::findOrFail($ciudadEntrega);
        $provincia = $ciudad->provincia;
        $tarifa = $ciudad->tarifa;
        $kilo = $ciudad->kilo_adicional;

        if ($provincia == "PICHINCHA") {
            return $costo = 10;
        } else if ($provincia == "GUAYAS") {
            $tipo = $ciudad->tipo_trayecto;
            if ($tipo != "ESPECIAL") {
                return $costo = 10;
            } else {
                $costo = $tarifa + ($kilo * $peso);
                return $costo;
            }
        } else {
            $costo = $tarifa + ($kilo * $peso);
            return $costo;
        }
    }

    public function naviera($volumen, $modalidad, $termino)
    {
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Flete maritimo')
            ->where('operacion_id', $termino)->get();
        foreach ($variables as $item) {
            $total = $item->valor * $volumen;
            $acumulador = $acumulador + $total;
        }
        return $acumulador;
    }
    public function gastosOrigen($modalidad, $termino)
    {
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos origen')
            ->where('operacion_id', $termino)->get();
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador;
    }

    public function gastosLocales($volumen, $modalidad, $termino)
    {
        $acumulador1 = 0;
        $variableSimple = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos locales simple')
            ->where('operacion_id', $termino)->get();
        foreach ($variableSimple as $item) {
            $acumulador1 = $acumulador1 + $item->valor;
        }
        $acumulador2 = 0;
        $variableCompuesta = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos locales compuesta')
            ->where('operacion_id', $termino)->get();
        foreach ($variableCompuesta as $item) {
            if (($item->valor) * $volumen <= $item->minimo) {
                $valor = $item->minimo;
            } else {
                $valor = ($item->valor) * $volumen;
            }
            $acumulador2 = $acumulador2 + $valor;
        }
        return $acumulador1 + $acumulador2;
    }

    public function otrosGastos($costo, $modalidad, $termino)
    {
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Otros gastos')
            ->where('operacion_id', $termino)->get();
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador + $costo;
    }

    public function show($id)
    {
        $cotizacion = Cotizaciones::whereid($id)->with(['carga', 'pais', 'modalidad', 'gastos', 'incoterms'])->first();
        $termino = $cotizacion->incoterms->puerto_id;
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $otrosGastos = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Otros gastos')->where('operacion_id', $termino)->get();
        $gastosOrigen = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos origen')->where('operacion_id', $termino)->get();
        $gastosLocalesCompuesta = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos locales compuesta')->where('operacion_id', $termino)->get();
        $gastosLocaleSimple = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos locales simple')->where('operacion_id', $termino)->get();
        $calculadoras = Calculadora::with('producto')->where('cotizacion_id', $id)->get();
        $mensaje = "true";
        $data = [
            'categoria' => $categoria,
            'insumo' => $insumo,
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje,
            'otrosGastos' => $otrosGastos,
            'gastosOrigen' => $gastosOrigen,
            'gastoSimple' => $gastosLocaleSimple,
            'gastosCompuesta' => $gastosLocalesCompuesta,
            'productos' => $calculadoras->pluck('producto'),
        ];
        return view('admin.calculadoras.colombia.detallesLcl', $data);
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
