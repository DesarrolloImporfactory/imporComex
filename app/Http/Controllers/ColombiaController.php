<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;
use App\Models\Paises;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Validacion;
use App\Models\Cotizaciones;
use Illuminate\Support\Facades\Validator;
use App\Models\tarifaGruapl;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailEspecialista;
use App\Models\Calculadora;
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\Categoria;
use App\Models\Ciudad;
use App\Models\Gasto;
use App\Models\ProductoInsumo;
use App\Models\Puerto;
use App\Models\PuertoChina;
use App\Models\Tarifario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Variables;
use App\Models\VariablesFcl;

class ColombiaController extends Controller
{


    public function index()
    {

        $insumos = Insumo::where('usuario_id', auth()->user()->id)->get();
        return response()->json([
            'status' => 200,
            'insumos' => $insumos,
        ]);
    }

    public function saveProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreInsumo' => 'required',
            'porcentajeInsumo' => 'required | numeric| min:0',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
            $producto = new Insumo();
            $producto->nombre = $request->input('nombreInsumo');
            $producto->porcentaje = $request->input('porcentajeInsumo');
            $producto->usuario_id = auth()->user()->id;
            $producto->save();
            return response()->json([
                'status' => 200,
                'message' => 'Producto creado!',
            ]);
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'insumos' => ['required'],
            'cantidad' => ['required'],

        ]);
        $input = $request->all();
        $cotizacion_id = $request->input("cotizacion_id");
        try {
            DB::beginTransaction();
            // $producto = Producto::create([
            //     "nombre"=>$input["nombre"],
            //     "cantidad"=>$input["cantidad"],
            //     "categoria_id"=>$input["categoria_id"],
            //     "precio"=>$this->calcular_precio($input["insumo_id"], $input["cantidades"]),
            // ]);
            foreach ($input["insumo_id"] as $key => $value) {
                ProductoInsumo::create([
                    "insumo_id" => $value,
                    "cotizacion_id" => $input["cotizacion_id"],
                    "cantidad" => $input["cantidades"][$key]
                ]);
                $ins = Insumo::find($value);
                $ins->update(["cantidad" => $ins->cantidad - $input["cantidades"][$key]]);
            }
            DB::commit();
            return redirect()->route('admin.colombia.edit', $cotizacion_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.colombia.edit', $cotizacion_id)->with('mensaje', $e->getMessage());
        }
    }

    public function calcular_precio($insumos, $cantidades)
    {
        $precio = 0;
        foreach ($insumos  as $key => $value) {
            $insumo = Insumo::find($value);
            $precio += ($insumo->precio * $cantidades[$key]);
        }
        return $precio;
    }

    public function create(Request $request)
    {

        $pais = $request->input('pais');
        $ciudades = Ciudad::all();
        $puertos = Puerto::all();
        $tarifarios = Tarifario::all();
        $modalidad = Modalidades::findOrFail($request->input('modalidad'));
        $productos = Insumo::all();
        $puertosChina = PuertoChina::all();
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();

        $mensajes = [
            'modalidad' => $modalidad,
            'pais' => $pais,
            'clientes' => $clientes,
            'ciudades' => $ciudades,
            'puertos' => $puertos,
            'tarifarios' => $tarifarios,
            'productos' => $productos,
            'puertosChina' => $puertosChina
        ];
        if ($modalidad->id == "1") {
            return view('admin.cargaCompleta.index', $mensajes);
        } else {
            return view('admin.calculadoras.colombia.grupal.create', $mensajes);
        }
    }

    public function store(Request $request)
    {
        if ($request->input('existe')) {
            $request->validate([
                'tipo_carga' => ['required'],
                'cliente' => ['required'],
                'peso' => ['required'],
                'cargas_id' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'numeric', 'min:0.5', 'max:15'],
                'ciudad_entrega' => ['required'],
            ]);
        } else {
            $request->validate([
                'peso' => ['required'],
                'tipo_carga' => ['required'],
                'cargas_id' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'numeric', 'min:0.5', 'max:15'],
                'ciudad_entrega' => ['required'],
            ]);
        }

        if ($request->input('cliente')) {

            $cliente = $request->input('cliente');
        } else {
            $cliente = $request->input('usuario_id');
        }

        $barcode = IdGenerator::generate(['table' => 'cotizaciones', 'field' => 'barcode', 'length' => 6, 'prefix' => date('y')]);
        //abajo hay codigo!!!! de referencia
        $data = User::whereHas("roles", function ($q) {
            $q->where("name", "Especialista");
        })->get();

        $usr = User::where('id', Auth::user()->id)->whereHas("roles", function ($q) {
            $q->where("name", "Especialista");
        })->first();

        $query = "Select count(id) as cotizaciones, especialista_id from cotizaciones where estado='aprobado' or estado='pendiente' group by especialista_id";
        $consulta = DB::connection('imporcomex')->select($query);

        if (isset($usr)) {
            $especialista = Auth::user()->id;
        } else {

            if (count($consulta) == 0) {
                $aleatorio = User::orderByRaw("RAND()")->whereHas("roles", function ($q) {
                    $q->where("name", "Especialista");
                })->first();

                $especialista = $aleatorio->id;
            } else {
                if (count($data) == count($consulta)) {
                    $id = min($consulta);
                    $especialista = $id->especialista_id;
                } else {

                    foreach ($consulta as $item) {
                        $especialistas = User::whereHas("roles", function ($q) {
                            $q->where("name", "Especialista");
                        })->get();

                        $aleatorio = $especialistas->random();
                        if ($aleatorio->id != $item->especialista_id) {
                            $especialista = $aleatorio->id;
                        }
                    }
                }
            }
        }
        ////Envio de correo electronico al especialista
        $datosEspecialista = User::findOrFail($especialista);
        $emailEsp = $datosEspecialista->email;
        //$correo = new EmailEspecialista;
        Mail::to($emailEsp)->send(new EmailEspecialista($cliente));
        /// fin de correo
        $proveedores = $request->input('cantidad_proveedores');
        $grupal = new Cotizaciones();
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
        $grupal->cargas_id = $request->input('cargas_id');
        $grupal->direccion = $request->input('direccion');
        $grupal->cantidad_proveedores = $request->input('cantidad_proveedores');
        $grupal->especialista_id = $especialista;
        $grupal->volumen = $request->input('volumen');
        $grupal->ciudad_id = $request->input('ciudad_entrega');
        $grupal->proceso = '2';
        $gastosOrigen = $this->volumen($request->input('volumen')) + (($proveedores * 50) - 50);
        $grupal->gastos_origen = $gastosOrigen;
        $flete = $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso'));
        $grupal->flete_maritimo = $flete;
        $grupal->total_logistica = $gastosOrigen  + $flete;

        $grupal->save();
        $data = Cotizaciones::latest('id')->first();

        return redirect()->route('admin.colombia.edit', $data);
    }

    public function volumen($volumen)
    {
        $sql = "SELECT * FROM tarifa_gruapls WHERE valor_min <= " . "$volumen" . " AND valor_max >= " . "$volumen" . " LIMIT 1";
        $query = DB::connection('imporcomex')->select($sql);
        foreach ($query as $data) {
            if (isset($data)) {
                $resultado = ($volumen * $data->vxcbm) / 1;
            } else {
                $resultado = 0;
            }
        }

        return $resultado;
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



    public function editpaso1($id)
    {
        $datos = Cotizaciones::with(['carga', 'pais', 'modalidad', 'ciudad', 'puerto', 'incoterms'])->whereid($id)->first();
        if (isset($datos->incoterms->puerto_id)) {
            $puerto = PuertoChina::findOrFail($datos->incoterms->puerto_id);
        } else {
            $puerto = 'falso';
        }

        $modalidad = $datos->modalidad->id;
        $puertos = Puerto::all();
        $ciudades = Ciudad::all();
        $productos = Insumo::all();
        $tarifarios = Tarifario::all();
        $puertosChina = PuertoChina::all();
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        if ($modalidad == 1) {
            return view('admin.paso1.editFcl', compact('datos', 'ciudades', 'clientes', 'puertos', 'productos', 'tarifarios', 'puertosChina', 'puerto'));
        } else {
            return view('admin.paso1.edit', compact('datos', 'ciudades', 'clientes', 'productos', 'puertosChina', 'puerto'));
        }
    }


    public function edit($data)
    {
        $categoria = Categoria::all();
        $productos = Calculadora::with('producto')->where('cotizacion_id', $data)->get();
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        $variables = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Otros gastos')->get();

        $mensaje = "true";
        $data = [
            'categoria' => $categoria,
            'insumo' => $productos->pluck('producto'),
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje,
            'variables' => $variables
        ];

        Session::put('tasks', request()->fullUrl());
        return view('admin.calculadoras.colombia.maestroAjax', $data);
    }

    public function back()
    {
        if (session('tasks')) {
            return redirect(session('tasks'));
        }
    }

    public function actualizarPaso1(Request $request, $id)
    {
        $request->validate([
            'peso' => ['required',],
            'cargas_id' => ['required'],
            'tipo_carga' => ['required'],
            'cantidad_proveedores' => ['required'],
            'direccion' => ['required', 'string', 'min:5'],
            'volumen' => ['required', 'numeric', 'min:0.5'],
            'ciudad_entrega' => ['required'],
            'termino' => ['required'],
        ]);

        if ($request->input('modalidad') == 2) {
            $this->updateLcl($request->all(), $id);
        } else if ($request->input('modalidad') == 3) {
            $proveedores = $request->input('cantidad_proveedores');
            $gastosOrigen = $this->volumen($request->input('volumen')) + (($proveedores * 50) - 50);
            $flete = $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso'));
            $datos = [
                'tipo_carga' => $request->input('tipo_carga'),
                'cargas_id' => $request->input('cargas_id'),
                'peso' => $request->input('peso'),
                'cantidad_proveedores' => $request->input('cantidad_proveedores'),
                'volumen' => $request->input('volumen'),
                'direccion' => $request->input('direccion'),
                'ciudad_id' => $request->input('ciudad_entrega'),
                'gastos_origen' => $gastosOrigen,
                'flete_maritimo' => $flete,
                'total_logistica' => $gastosOrigen  + $flete
            ];
            Cotizaciones::where('id', $id)->update($datos);
        } else {
            $this->updateFcl($request->all(), $id);
        }

        $validacion = Validacion::where('cotizacion_id', $id)->get();
        if ($request->input('modalidad') == 2) {
            if (count($validacion) > 0) {
                return redirect()->route('admin.colombia.show', $id);
            } else {
                return redirect()->route('admin.colombia.show', $id)->with('mensaje', 'Completemos la cotizacion!');
            }
        } else {
            if (count($validacion) > 0) {
                return redirect()->route('admin.colombia.edit', $id);
            } else {
                return redirect()->route('admin.colombia.edit', $id)->with('mensaje', 'Completemos la cotizacion!');
            }
        }
    }

    public function show($id)
    {
        $cotizacion = Cotizaciones::whereid($id)->with(['carga', 'pais', 'modalidad', 'gastos'])->first();
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $otrosGastos = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Otros gastos')->get();
        $gastosOrigen = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos origen')->get();
        $gastosLocalesCompuesta = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos locales compuesta')->get();
        $gastosLocaleSimple = Variables::where('modalidad_id', $cotizacion->modalidad_id)->where('tipo', 'Gastos locales simple')->get();
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

    public function updateLcl($request, $id)
    {
        $gastos_origen = $this->gastosOrigen($request['modalidad'], $request['termino']);
        $fleteMaritimo = $this->naviera($request['volumen'], $request['modalidad'], $request['termino']);
        $flete = $this->ciudadEntrega($request['ciudad_entrega'], $request['peso']);
        $collect = $this->collect($fleteMaritimo, $request['modalidad'], $request['termino']);
        $totalPagar = ($this->gastosLocales($request['volumen'], $id, $collect, $request['modalidad'], $request['termino'])) + $collect;
        $gastos_sin_iva = $totalPagar;
        $gastosLocales = ($totalPagar + ($totalPagar * 0.12));
        $otrosGastos = $this->otrosGastos($flete, $request['modalidad'], $request['termino']);
        $datos = [
            'tipo_carga' => $request['tipo_carga'],
            'cargas_id' => $request['cargas_id'],
            'peso' => $request['peso'],
            'cantidad_proveedores' => $request['cantidad_proveedores'],
            'volumen' => $request['volumen'],
            'direccion' => $request['direccion'],
            'ciudad_id' => $request['ciudad_entrega'],
            'incoterms_id' => $request['puerto'] ?? 'NULL',
            'flete_maritimo' => $fleteMaritimo,
            'flete' => $flete,
            'collect' => $collect,
            'gastos_sin_iva' => $gastos_sin_iva,
            'gastos_origen' => $gastos_origen,
            'gastos_local' => $gastosLocales,
            'otros_gastos' => $otrosGastos,
            'total_logistica' => $otrosGastos + $fleteMaritimo + $gastosLocales + $gastos_origen
        ];
        Cotizaciones::where('id', $id)->update($datos);
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
    public function collectFcl($flete, $modalidad, $termino)
    {
        $termino_id = PuertoChina::where('name', $termino)->first();
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'COLLECT FEE')
            ->where('operacion_id', $termino_id->id)->first();
        $total = $flete * $variables->valor;
        if ($total <= $variables->minimo) {
            $total = $variables->minimo;
        }
        return $total;
    }

    public function fclocal($collect, $modalidad)
    {
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos locales simple')->get();
        $acumulador = 0;
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador + $collect;
    }
    public function tarifa($ciudadEntrega, $peso)
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
    public function updateFcl($request, $id)
    {

        $gastos_origen = $this->gastosOrigen($request['modalidad'], $request['termino']);
        $fleteMaritimo = $this->tarifa($request['ciudad_entrega'], $request['peso']);
        $flete = $request['volumen'];
        $collect = $this->collectFcl($flete, $request['modalidad'], $request['termino']);
        $gastos_sin_iva =  $this->fclocal($collect, $request['modalidad']);
        $gastosLocales = $this->fclocal($collect, $request['modalidad']) + ($this->fclocal($collect, $request['modalidad']) * 0.12);
        $otrosGastos = $this->otrosGastosFcl($fleteMaritimo, $request['modalidad']);
        $datos = [
            'puerto_id' => $request['puerto_id'],
            'tipo_carga' => $request['tipo_carga'],
            'cargas_id' => $request['cargas_id'],
            'peso' => $request['peso'],
            'cantidad_proveedores' => $request['cantidad_proveedores'],
            'volumen' => $request['volumen'],
            'direccion' => $request['direccion'],
            'ciudad_id' => $request['ciudad_entrega'],
            'flete' => $flete,
            'gastos_sin_iva' => $gastos_sin_iva,
            'gastos_origen' => $gastos_origen,
            'flete_maritimo' => $fleteMaritimo,
            'gastos_local' => $gastosLocales,
            'otros_gastos' => $otrosGastos,
            'total_logistica' => $otrosGastos + $flete + $gastosLocales + $gastos_origen
        ];
        Cotizaciones::where('id', $id)->update($datos);
    }

    public function update(Request $request, $id)
    {
        $datos = array(
            "proceso" => '3'
        );

        Cotizaciones::whereid($id)->update($datos);
        //return response()->json($datos);
        return redirect('colombia')->with('mensaje', 'Cotizacion Actualizado');
    }

    public function destroy($id)
    {
        //
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
        //falta aplicar el termino
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Gastos origen')->get();
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }
        return $acumulador;
    }

    public function gastosLocales($volumen, $id, $collect, $modalidad, $termino)
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

    public function otrosGastosFcl($flete, $modalidad)
    {
        $acumulador = 0;
        $variables = Variables::where('modalidad_id', $modalidad)->where('tipo', 'Otros gastos')->get();
        foreach ($variables as $item) {
            $acumulador = $acumulador + $item->valor;
        }

        return $acumulador + $flete;
    }
}
