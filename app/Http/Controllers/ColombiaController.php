<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;
use App\Models\Paises;
use App\Models\tipo_cargas;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Validacion;
use App\Models\Cotizaciones;
use Illuminate\Support\Facades\Validator;
use App\Models\tarifaGruapl;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailEspecialista;
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\Categoria;
use App\Models\Ciudad;
use App\Models\ProductoInsumo;


class ColombiaController extends Controller
{


    public function index()
    {
        return "index";
    }

    public function saveProduct(Request $request)
    {
        $cotizacion_id = $request->input('cotizacion_id');
        $datos = new Insumo();
        $datos->nombre = $request->input('nombreInsumo');
        //$datos->categoria_id = $request->input('categoria_id');
        $datos->cantidad = $request->input('cantidadInsumo');
        $datos->precio = $request->input('precioInsumo');
        $datos->porcentaje = $request->input('porcentajeInsumo');
        $datos->save();
        return redirect()->route('admin.colombia.edit', $cotizacion_id);
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
            'ciudades' => $ciudades

        ];
        if ($modalidad->id == "3") {
            return view('admin.calculadoras.colombia.grupal.create', $mensajes);
        } elseif ($modalidad->id == "1") {
            return view('admin.calculadoras.colombia.fcl', $mensajes);
        } else {
            return view('admin.calculadoras.colombia.lcl', $mensajes);
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
                'liquidos' => ['required'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:0', 'max:15', 'numeric:0'],
                'ciudad_entrega' => ['required'],
            ]);
        } else {
            $request->validate([
                'inflamable' => ['required'],
                'peso' => ['required',],
                'cargas_id' => ['required'],
                'tiene_bateria' => ['required'],
                'liquidos' => ['required'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:0', 'max:15', 'numeric:0'],
                'ciudad_entrega' => ['required'],
            ]);
        }

        if ($request->input('cliente')) {

            $cliente = $request->input('cliente');
        } else {
            $cliente = $request->input('usuario_id');
        }


        $grupal = new Cotizaciones();
        $volumen = $request->input('volumen');

        switch ($volumen) {
            case ($volumen > 0 && $volumen < 1):

                $datos = tarifaGruapl::findOrFail(1);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen >= 1 && $volumen < 2):

                $datos = tarifaGruapl::findOrFail(2);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen >= 2 && $volumen < 3):

                $datos = tarifaGruapl::findOrFail(3);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen >= 3 && $volumen < 4):

                $datos = tarifaGruapl::findOrFail(4);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen >= 4 && $volumen < 5):

                $datos = tarifaGruapl::findOrFail(5);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen >= 5 && $volumen < 6):

                $datos = tarifaGruapl::findOrFail(6);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen >= 6 && $volumen < 7):

                $datos = tarifaGruapl::findOrFail(7);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen > 7 && $volumen <= 9):

                $datos = tarifaGruapl::findOrFail(8);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen > 9 && $volumen <= 12):

                $datos = tarifaGruapl::findOrFail(9);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
            case ($volumen > 12 && $volumen <= 15):

                $datos = tarifaGruapl::findOrFail(14);
                $resultado = ($volumen * $datos->vxcbm) / 1;

                break;
        }

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

        $consulta = DB::select($query);
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
        $grupal->barcode = $barcode;
        $peso = $request->input('peso') . 'kg';
        $grupal->usuario_id = $cliente;
        $grupal->pais_id = $request->input('pais');
        $grupal->modalidad_id = $request->input('modalidad');
        $grupal->inflamable = $request->input('inflamable');
        $grupal->peso = $peso;
        $grupal->estado = "Pendiente";
        $grupal->origen = $request->input('origen');
        $grupal->tiene_bateria = $request->input('tiene_bateria');
        $grupal->liquidos = $request->input('liquidos');
        $grupal->cargas_id = $request->input('cargas_id');
        $grupal->direccion = $request->input('direccion');
        $grupal->especialista_id = $especialista;
        $grupal->volumen = $request->input('volumen');
        $grupal->ciudad_id = $request->input('ciudad_entrega');
        $grupal->proceso = '2';
        $grupal->total_logistica = $resultado;

        $grupal->save();
        $data = Cotizaciones::latest('id')->first();

        return redirect()->route('admin.colombia.edit', $data);
    }


    public function editpaso1($id)
    {
        $datos = Cotizaciones::with(['carga', 'pais', 'modalidad', 'ciudad'])->whereid($id)->first();
        $ciudades = Ciudad::all();
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        return view('admin.paso1.edit', compact('datos', 'ciudades', 'clientes'));
    }


    public function edit($data)
    {
        $categoria = Categoria::all();
        $insumo = Insumo::all();
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        $mensaje = "true";
        $data = [
            'categoria' => $categoria,
            'insumo' => $insumo,
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje
        ];
        return view('admin.calculadoras.colombia.maestroAjax', $data);
    }

    public function actualizarPaso1(Request $request, $id)
    {
        $request->validate([
            'inflamable' => ['required'],
            'peso' => ['required',],
            'cargas_id' => ['required'],
            'tiene_bateria' => ['required'],
            'liquidos' => ['required'],
            'direccion' => ['required', 'string', 'min:5'],
            'volumen' => ['required', 'min:0', 'max:15', 'numeric:0'],
            'ciudad_entrega' => ['required'],
        ]);

        $datos = [
            'inflamable'=> $request->input('inflamable'),
            'tiene_bateria' => $request->input('tiene_bateria'),
            'liquidos' => $request->input('liquidos'),
            'cargas_id'=>$request->input('cargas_id'),
            'peso' => $request->input('peso'),
            'volumen' => $request->input('volumen'),
            'direccion' => $request->input('direccion'),
            'ciudad_id' => $request->input('ciudad_entrega')
        ];
        Cotizaciones::where('id', $id)->update($datos);
        $validacion = Validacion::where('cotizacion_id', $id)->get();
        if (count($validacion) > 0) {
            return redirect()->route('editar.paso2', $id);
        } else {
            return redirect()->route('admin.colombia.edit', $id)->with('mensaje', 'Completemos la cotizacion!');
        }
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
}
