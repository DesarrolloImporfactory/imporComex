<?php

namespace App\Http\Controllers\Lcl;

use App\Http\Controllers\Controller;
use App\Models\Cotizaciones;
use Illuminate\Http\Request;
use App\Models\tarifaGruapl;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailEspecialista;
use App\Models\Ciudad;
use App\Models\Variables;

class CargaSueltaController extends Controller
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
                'volumen' => ['required', 'min:0', 'max:15', 'numeric:0'],
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
        $proveedores = $request->input('cantidad_proveedores');

        $grupal->barcode = $barcode;
        $peso = $request->input('peso') . 'kg';
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
        $grupal->total_logistica = $this->volumen($request->input('volumen')) ;

        $gastosOrigen = $this->volumen($request->input('volumen'));
        $collect = ($this->volumen($request->input('volumen'))) * 0.0425;
        $totalPagar = ($this->gastosLocales($request->input('volumen'))) + $collect;
        $gastosLocales = $totalPagar+($totalPagar * 0.12);
        // + $this->ciudadEntrega($request->input('ciudad_entrega'), $request->input('peso')
        $newData = [
            'grupal' => $grupal,
            'gastosOrigen' =>$gastosOrigen,
            'collect' => $collect,
            'gastos Locales' => $gastosLocales
        ];
        return ($newData);
        // $grupal->save();
        // $data = Cotizaciones::latest('id')->first();

        // return redirect()->route('admin.colombia.edit', $data);
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
                $costo = ($tarifa + $kilo) * $peso;
                return $costo;
            }
        } else {
            $costo = ($tarifa + $kilo) * $peso;
            return $costo;
        }
    }

    public function volumen($volumen){
        $tasa = Variables::findOrFail(1);
        $baf = Variables::findOrFail(2);
        $aduana = Variables::findOrFail(3);
        $tasaValor = $tasa->valor;
        $bafValor = $baf->valor;
        $aduanaValor = $aduana->valor;

        $total_gastos_origen = ($tasaValor*$volumen)+$bafValor+$aduanaValor;

        return $total_gastos_origen;

    }

    public function gastosLocales($volumen){
        
        $cargo = Variables::findOrFail(4);
        $transmicion = Variables::findOrFail(5);
        $administracion = Variables::findOrFail(6);
        $portuario = Variables::findOrFail(7);
        
        $transmicionValor = ($transmicion->valor)*1;
        $administracionValor = ($administracion->valor)*1;

        if(($cargo->valor)*$volumen <= $cargo->minimo){
            $valorLogistico = $cargo->minimo;
        }else{
            $valorLogistico = ($cargo->valor)*$volumen;
        }

        if(($portuario->valor)*$volumen < $portuario->minimo){
            $portuarioValor = $portuario->minimo;
        }else{
            $portuarioValor = ($portuario->valor)*$volumen;
        }

        $total = $transmicionValor+$administracionValor+$valorLogistico+$portuarioValor;
        return $total;
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
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
