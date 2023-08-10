<?php

namespace App\Http\Livewire\Aerea;

use App\Models\Aereo;
use App\Models\AereoTemp;
use App\Models\Cotizaciones;
use App\Models\Insumo;
use App\Models\User;
use App\Models\Variables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;

class AdminAereas extends Component
{
    public $pais, $proveedor, $carga, $cliente,$producto,$nombre_producto, $valor_porcentual;
    public $cartones, $largo, $ancho, $alto, $peso_bruto_carton, $total, $tasa, $flete_aereo, $awb, $handle, $costo_envio;
    protected $listeners = ['delete'];

    public function mount($pais)
    {
        $this->pais = $pais;
        $this->total();
    }
    public function render()
    {
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();

        $insumos = Insumo::where('usuario_id', auth()->user()->id)->get();

        $calculos = AereoTemp::with('producto')->where('usuario_id',auth()->user()->id)->get();

        return view('livewire.aerea.admin-aereas', compact('clientes', 'calculos','insumos'))->extends('adminlte::page')
            ->section('content');
    }
    public $rules = [
        'producto' => 'required',
        'cartones' => 'required|numeric|min:1',
        'largo' => 'required|numeric|min:0.1',
        'ancho' => 'required|numeric|min:0.1',
        'alto' => 'required|numeric|min:0.1',
        'peso_bruto_carton' => 'required|numeric|min:0.1'
    ];

    public function createProduct()
    {
        $this->validate([
            'nombre_producto' => 'required',
        'valor_porcentual' => 'required|numeric|min:0'
        ]);
        try {
            Insumo::create([
                'nombre' => $this->nombre_producto,
                'porcentaje' => $this->valor_porcentual,
                'usuario_id' => auth()->user()->id
            ]);
            $this->emit('render_update');

            $this->emit('alert', 'Producto creado!');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }

    public function create()
    {
        $this->validate([
            'carga' => 'required',
            'proveedor' => 'required',
            'costo_envio' => 'required|numeric|gt:0'
        ]);
        $cotizacion = new Cotizaciones();
        $cotizacion->usuario_id = $this->cliente ?? auth()->user()->id;
        $cotizacion->pais = $this->pais;
        $cotizacion->barcode = IdGenerator::generate(['table' => 'cotizaciones', 'field' => 'barcode', 'length' => 6, 'prefix' => date('y')]);
        $cotizacion->modalidad_id = '4';
        $cotizacion->tipo_carga = $this->carga;
        $cotizacion->estado = 'Pendiente';
        $cotizacion->time = Carbon::now();
        $cotizacion->cantidad_proveedores = $this->proveedor;
        $cotizacion->especialista_id = $this->especialista();
        $cotizacion->flete = $this->costo_envio;
        $cotizacion->proceso = '3';
        $cotizacion->total_logistica = $this->costo_envio + 100;
        $cotizacion->save();
        $this->productos($cotizacion->id);
        return redirect()->to('/cotizacion/aerea/' . $cotizacion->id);
        try {
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function calcular()
    {
        $this->validate();
        $peso_pieza  = (($this->largo * $this->ancho * $this->alto) * 200) / 1000000;
        $peso_total = $peso_pieza * $this->cartones;
        $bruto_piezas =  $this->peso_bruto_carton * $this->cartones;
        try {
            AereoTemp::create([
                'usuario_id' => auth()->user()->id,
                'insumo_id' => $this->producto,
                'cartones' => $this->cartones,
                'largo' => $this->largo,
                'alto' => $this->alto,
                'ancho' => $this->ancho,
                'peso_volumetrico_pieza' => $peso_pieza,
                'peso_volumetrico_total' => $peso_total,
                'peso_bruto_carton' => $this->peso_bruto_carton,
                'peso_bruto_piezas' => $bruto_piezas,
                'total' => max($peso_total, $bruto_piezas),
            ]);
            $this->total();
            $this->emit('alert', 'Valores calculados!');
            $this->reset([
                'cartones',
                'largo',
                'ancho',
                'alto',
                'producto',
                'peso_bruto_carton'
            ]);
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }

    public function total()
    {

        $this->total = AereoTemp::where('usuario_id', auth()->user()->id)->sum('total');
        if ($this->total > 0) {
            $this->awb = 50;
            $this->handle = 65;
            $this->tasa = Variables::select('valor')->where('tipo', 'Aereo')->first();
            $this->flete_aereo = $this->total * $this->tasa->valor;
            $this->costo_envio = $this->flete_aereo + $this->awb + $this->handle;
        } else {
            $this->costo_envio = '0';
        }
    }

    public function delete(Int $id)
    {
        try {
            AereoTemp::destroy($id);
            $this->total();
            $this->emit('alert', 'Registro eliminado!');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function especialista()
    {
        $data = User::latest('created_at')->whereHas("roles", function ($q) {
            $q->where("name", "Especialista");
        })->first();

        if (isset($data)) {
            $idEspecialistaNuevo = $data->id;
        }
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
        return $especialista;
    }

    public function productos($id)
    {
        $calculos = AereoTemp::where('usuario_id', auth()->user()->id)->get();
        foreach ($calculos as $calculo) {
            Aereo::create([
                'cotizacion_id' => $id,
                'insumo_id' => $calculo->insumo_id,
                'cartones' => $calculo->cartones,
                'largo' => $calculo->largo,
                'ancho' => $calculo->ancho,
                'alto' => $calculo->alto,
                'peso_volumetrico_pieza' => $calculo->peso_volumetrico_pieza,
                'peso_volumetrico_total' => $calculo->peso_volumetrico_total,
                'peso_bruto_carton' => $calculo->peso_bruto_carton,
                'peso_bruto_piezas' => $calculo->peso_bruto_piezas,
                'total' => $calculo->total,
            ]);
        }
        AereoTemp::where('usuario_id', auth()->user()->id)->delete();
        return true;
    }
}
