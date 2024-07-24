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
use App\Models\PuertoChina;
use App\Models\Tarifario;
use App\Models\VariablesFcl;
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
                'peso' => ['required'],
                'tipo_carga' => ['required'],
                'termino' => ['required'],
                'cargas_id' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:1', 'numeric:0'],
                'puerto_id' => ['required'],
                'ciudad_entrega' => ['required'],
            ]);
        } else {
            $request->validate([
                'tipo_carga' => ['required'],
                'peso' => ['required',],
                'cargas_id' => ['required'],
                'termino' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
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
        $grupal->pais = $request->input('pais');
        $grupal->modalidad_id = $request->input('modalidad');
        $grupal->tipo_carga = $request->input('tipo_carga');
        $grupal->peso = $peso;
        $grupal->estado = "Pendiente";
        $grupal->time = Carbon::now();
        $grupal->origen = $request->input('origen');
        $grupal->termino = $request->input('termino');
        $grupal->puerto_id = $request->input('puerto_id');
        //ojo
        $grupal->incoterms_id = $request->input('puerto_id');
        $grupal->cargas_id = $request->input('cargas_id');
        $grupal->direccion = $request->input('direccion');
        $grupal->cantidad_proveedores = $request->input('cantidad_proveedores');
        $grupal->especialista_id = $especialista;
        $grupal->tarifa_id = $request->input('ciudad_entrega');
        $grupal->proceso = '2';
        $gastos_origen = $this->gastosOrigen($request->input('modalidad'));
        $grupal->gastos_origen = $gastos_origen;
        $flete_maritimo = $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso'));
        $grupal->flete_maritimo = $flete_maritimo;
        $grupal->flete = $request->input('volumen');
        $collect = $this->collect($request->input('volumen'),$request->input('modalidad'),$request->input('termino'));
        $gastos_sin_iva = $this->fclocal($collect,$request->input('modalidad'));
        $grupal->gastos_sin_iva = $gastos_sin_iva;
        $gastosLocales = $this->fclocal($collect,$request->input('modalidad')) + ($this->fclocal($collect,$request->input('modalidad')) * 0.12);
        $grupal->gastos_local = $gastosLocales;
        $otrosGastos = $this->otrosGastosFcl($flete_maritimo, $request->input('modalidad'));
        $grupal->otros_gastos = $otrosGastos;
        $grupal->total_logistica = $otrosGastos + $request->input('volumen') + $gastos_origen + $gastosLocales;

        $grupal->save();
        $data = Cotizaciones::latest('id')->first();
        return redirect()->route('contenedorCompleto.edit', $data);
    }

    public function collect($flete, $modalidad, $termino)
    {
        $termino_id = PuertoChina::where('name',$termino)->first();
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'COLLECT FEE')
            ->where('operacion_id', $termino_id->id)->first();
        $total = $flete * $variables->valor;
        if ($total <= $variables->minimo) {
            $total = $variables->minimo;
        }
        return $total;
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
    public function otrosGastosFcl($flete, $modalidad)
    {
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Otros gastos')->get();
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador+$flete;
    }
    public function fclocal($collect,$modalidad)
    {
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos locales simple')->get();
        $acumulador = 0;
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador + $collect;
    }

    public function gastosOrigen($modalidad)
    {
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos origen')->get();
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador;
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $cotizacion = Cotizaciones::whereid($id)->with(['carga', 'pais', 'modalidad'])->first();
        $variables = Variables::where('modalidad_id',$cotizacion->modalidad_id)->where('tipo','Otros gastos')->get();
        
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
