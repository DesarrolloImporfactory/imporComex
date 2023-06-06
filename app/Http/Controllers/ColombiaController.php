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
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\Categoria;
use App\Models\Ciudad;
use App\Models\ProductoInsumo;
use App\Models\Puerto;
use App\Models\Tarifario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Variables;

class ColombiaController extends Controller
{


    public function index()
    {
        $insumos = Insumo::all();
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
        $ciudades = Ciudad::all();
        $idModalidad = $request->input('modalidad');
        $puertos = Puerto::all();
        $tarifarios = Tarifario::all();
        $modalidad = Modalidades::findOrFail($idModalidad);
        $idPais = $request->input('pais');
        $pais = Paises::findOrFail($idPais);
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();

        $mensajes = [
            'modalidad' => $modalidad,
            'paises' => $pais,
            'clientes' => $clientes,
            'ciudades' => $ciudades,
            'puertos' => $puertos,
            'tarifarios' => $tarifarios
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
                'cliente' => ['required'],
                'inflamable' => ['required'],
                'peso' => ['required',],
                'cargas_id' => ['required'],
                'tiene_bateria' => ['required'],
                'cantidad_proveedores' => ['required', 'numeric', 'min:1', 'max:6'],
                'liquidos' => ['required'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'numeric', 'min:0.5', 'max:15'],
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
        $consulta = DB::select($query);

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
        $grupal->pais_id = $request->input('pais');
        $grupal->modalidad_id = $request->input('modalidad');
        $grupal->inflamable = $request->input('inflamable');
        $grupal->peso = $peso;
        $grupal->estado = "Pendiente";
        $grupal->time = Carbon::now();
        $grupal->origen = $request->input('origen');
        $grupal->tiene_bateria = $request->input('tiene_bateria');
        $grupal->liquidos = $request->input('liquidos');
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
    public function otrosGastos( $costo)
    {
        $agente = Variables::findOrFail(8);
        $bodegaje = Variables::findOrFail(9);
        
        $total = ($agente->valor * 1.12) + $costo + $bodegaje->valor;
        return $total;
    }


    public function editpaso1($id)
    {
        $datos = Cotizaciones::with(['carga', 'pais', 'modalidad', 'ciudad', 'puerto'])->whereid($id)->first();
        $modalidad = $datos->modalidad->id;
        $puertos = Puerto::all();
        $ciudades = Ciudad::all();
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        if ($modalidad == 1) {
            return view('admin.paso1.editFcl', compact('datos', 'ciudades', 'clientes', 'puertos'));
        } else {
            return view('admin.paso1.edit', compact('datos', 'ciudades', 'clientes'));
        }
    }


    public function edit($data)
    {
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        $variables = Variables::findOrFail(9);
        $mensaje = "true";
        $data = [
            'categoria' => $categoria,
            'insumo' => $insumo,
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
            'inflamable' => ['required'],
            'peso' => ['required',],
            'cargas_id' => ['required'],
            'tiene_bateria' => ['required'],
            'cantidad_proveedores' => ['required'],
            'liquidos' => ['required'],
            'direccion' => ['required', 'string', 'min:5'],
            'volumen' => ['required', 'numeric', 'min:0.5'],
            'ciudad_entrega' => ['required'],
        ]);

        if ($request->input('modalidad') == 2) {
            $this->updateLcl($request->all(), $id);
        } else if ($request->input('modalidad') == 3) {
            $proveedores = $request->input('cantidad_proveedores');
            $gastosOrigen = $this->volumen($request->input('volumen')) + (($proveedores * 50) - 50);
            $flete = $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso'));
            $datos = [
                'inflamable' => $request->input('inflamable'),
                'tiene_bateria' => $request->input('tiene_bateria'),
                'liquidos' => $request->input('liquidos'),
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
        if (count($validacion) > 0) {
            return redirect()->route('admin.colombia.edit', $id);
        } else {
            return redirect()->route('admin.colombia.edit', $id)->with('mensaje', 'Completemos la cotizacion!');
        }
    }
    
    public function updateLcl($request, $id)
    {
        $gastos_origen = $this->gastosOrigen();
        $fleteMaritimo = $this->naviera($request['volumen']);
        $flete = $this->ciudadEntrega($request['ciudad_entrega'], $request['peso']);
        $collect = $fleteMaritimo * 0.0425;
        $totalPagar = ($this->gastosLocales($request['volumen'])) + $collect;
        $gastosLocales = ($totalPagar + ($totalPagar * 0.12));
        $otrosGastos = $this->otrosGastos($flete);
        $datos = [
            'inflamable' => $request['inflamable'],
            'tiene_bateria' => $request['tiene_bateria'],
            'liquidos' => $request['liquidos'],
            'cargas_id' => $request['cargas_id'],
            'peso' => $request['peso'],
            'cantidad_proveedores' => $request['cantidad_proveedores'],
            'volumen' => $request['volumen'],
            'direccion' => $request['direccion'],
            'ciudad_id' => $request['ciudad_entrega'],
            'flete_maritimo' => $fleteMaritimo,
            'flete' => $flete,
            'gastos_origen' => $gastos_origen,
            'gastos_local' => $gastosLocales,
            'otros_gastos' => $otrosGastos,
            'total_logistica' => $otrosGastos + $fleteMaritimo + $gastosLocales + $gastos_origen
        ];
        Cotizaciones::where('id', $id)->update($datos);
    }
    
    public function fclocal($collect)
    {
        $tasa = Variables::findOrFail(10);
        $transmicion = Variables::findOrFail(5);
        return $tasa->valor + $transmicion->minimo + $collect;
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

        $gastos_origen = $this->gastosOrigen();
        $fleteMaritimo = $request['volumen'];
        $flete = $this->tarifa($request['ciudad_entrega'], $request['peso']);
        $collect = $fleteMaritimo * 0.05;
        $gastosLocales = $this->fclocal($collect) + ($this->fclocal($collect) * 0.12);
        $otrosGastos = $this->otrosGastosFcl($request['ciudad_entrega'], $request['peso']);
        $datos = [
            'puerto_id' => $request['puerto_id'],
            'inflamable' => $request['inflamable'],
            'tiene_bateria' => $request['tiene_bateria'],
            'liquidos' => $request['liquidos'],
            'cargas_id' => $request['cargas_id'],
            'peso' => $request['peso'],
            'cantidad_proveedores' => $request['cantidad_proveedores'],
            'volumen' => $request['volumen'],
            'direccion' => $request['direccion'],
            'ciudad_id' => $request['ciudad_entrega'],
            'flete' => $flete,
            'gastos_origen' => $gastos_origen,
            'flete_maritimo' => $fleteMaritimo ,
            'gastos_local' => $gastosLocales,
            'otros_gastos' => $otrosGastos,
            'total_logistica' => $otrosGastos + $fleteMaritimo + $gastosLocales + $gastos_origen
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
        //return $datos;
    }



    public function destroy($id)
    {
        //
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

        $cargo = Variables::findOrFail(4);
        $transmicion = Variables::findOrFail(5);
        $administracion = Variables::findOrFail(6);
        $portuario = Variables::findOrFail(7);

        $transmicionValor = ($transmicion->valor) * 1;
        $administracionValor = ($administracion->valor) * 1;

        if (($cargo->valor) * $volumen <= $cargo->minimo) {
            $valorLogistico = $cargo->minimo;
        } else {
            $valorLogistico = ($cargo->valor) * $volumen;
        }

        if (($portuario->valor) * $volumen < $portuario->minimo) {
            $portuarioValor = $portuario->minimo;
        } else {
            $portuarioValor = ($portuario->valor) * $volumen;
        }

        $total = $transmicionValor + $administracionValor + $valorLogistico + $portuarioValor;
        return $total;
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
}
