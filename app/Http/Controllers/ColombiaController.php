<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalidades;
use App\Models\Paises;
use App\Models\tipo_cargas;
use App\Models\User;
use App\Models\Incoterm;
use App\Models\Validacion;
use App\Models\Cotizaciones;
use Illuminate\Support\Facades\Validator;
use App\Models\tarifaGruapl;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ColombiaController extends Controller
{
   

    public function index()
    {
        return "index";
    }

    public function create(Request $request)
    {

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
            'clientes'=>$clientes

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
        if($request->input('existe')){
            $request->validate([
                'cliente' => ['required'], 
                'producto' => ['required', 'string', 'max:2555'],
            'peso' => ['required',],
            'cargas_id' => ['required'],
            'tiene_bateria' => ['required'],
            'precio_china' => ['required', 'numeric:0'],
            'direccion' => ['required', 'string', 'min:5'],
            'volumen' => ['required', 'min:0', 'max:15', 'numeric:0'],
            'ciudad_entrega' => ['required'],
            ]);
        }else{
            $request->validate([
                'producto' => ['required', 'string', 'max:2555'],
                'peso' => ['required',],
                'cargas_id' => ['required'],
                'tiene_bateria' => ['required'],
                'precio_china' => ['required', 'numeric:0'],
                'direccion' => ['required', 'string', 'min:5'],
                'volumen' => ['required', 'min:0', 'max:15', 'numeric:0'],
                'ciudad_entrega' => ['required'],
            ]);
        }

        if($request->input('cliente')){
            
            $cliente = $request->input('cliente');
        }else{
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
        
        $grupal->barcode = $barcode;
        $peso = $request->input('peso') . 'kg';
        $grupal->usuario_id = $cliente;
        $grupal->pais_id = $request->input('pais');
        $grupal->modalidad_id = $request->input('modalidad');
        $grupal->producto = $request->input('producto');
        $grupal->peso = $peso;
        $grupal->estado = "Pendiente";
        $grupal->origen = $request->input('origen');
        $grupal->tiene_bateria = $request->input('tiene_bateria');
        $grupal->precio_china = $request->input('precio_china');
        $grupal->cargas_id = $request->input('cargas_id');
        $grupal->direccion = $request->input('direccion');
        $grupal->especialista_id = $especialista;
        $grupal->volumen = $request->input('volumen');
        $grupal->ciudad_entrega = $request->input('ciudad_entrega');
        $grupal->proceso = '2';
        $grupal->total_logistica = $resultado;

        $grupal->save();
        $data = Cotizaciones::latest('id')->first();

        return redirect()->route('admin.colombia.edit', $data);
    }


    public function editpaso1($id)
    {
        $datos = Cotizaciones::with(['carga', 'pais', 'modalidad'])->whereid($id)->first();
        return view('admin.paso1.edit', compact('datos'));
    }


    public function edit($data)
    {
        $cotizacion = Cotizaciones::whereid($data)->with(['carga', 'pais', 'modalidad'])->first();
        $mensaje = "true";
        $data = [
            'cotizacion' => $cotizacion,
            'mensaje' => $mensaje
        ];
        return view('admin.calculadoras.colombia.grupal.formulario', $data);
    }

    public function actualizarPaso1(Request $request, $id)
    {
        $usuarioId=$request->input('usuario_id');
        $datos=[
            'producto'=>$request->input('producto'),
            'tiene_bateria'=>$request->input('tiene_bateria'),
            'peso'=>$request->input('peso'),
            'volumen'=>$request->input('volumen'),
            'precio_china'=>$request->input('precio_china'),
            'direccion'=>$request->input('direccion'),
            'ciudad_entrega'=>$request->input('ciudad_entrega')
        ];
        Cotizaciones::where('id',$id)->update($datos);
        $validacion=Validacion::where('cotizacion_id',$id)->get();
        if(count($validacion)>0){
            return redirect()->route('editar.paso2', $id);
        }else{
            return redirect()->route('admin.colombia.edit', $id)->with('mensaje','Completemos la cotizacion!');
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
