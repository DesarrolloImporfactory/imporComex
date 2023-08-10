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

class EditAerea extends Component
{
    public $pais,$insumos, $proveedor, $carga, $cliente, $cotizacion_id, $producto,$nombre_producto, $valor_porcentual;
    public $cartones, $largo, $ancho, $alto, $peso_bruto_carton, $total, $tasa, $flete_aereo, $awb, $handle, $costo_envio;
    protected $listeners = ['delete','render_update' =>'render'];

    public function mount($cotizacion_id)
    {
        // $this->pais = $pais;
        $this->cotizacion_id = $cotizacion_id;
        $cotizacion = Cotizaciones::findOrFail($this->cotizacion_id);
        $this->carga = $cotizacion->tipo_carga;
        $this->proveedor = $cotizacion->cantidad_proveedores;
        $this->cliente = $cotizacion->usuario_id;

        $this->total();
    }

    public function render()
    {
        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        $calculos = Aereo::with('producto')->where('cotizacion_id', $this->cotizacion_id)->get();
        $this->insumos = Insumo::where('usuario_id', auth()->user()->id)->get();
        return view('livewire.aerea.edit-aerea', compact('clientes', 'calculos'))->extends('adminlte::page')
            ->section('content');
    }

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

    public $rules = [
        'producto' => 'required',
        'cartones' => 'required|numeric|min:1',
        'largo' => 'required|numeric|min:0.1',
        'ancho' => 'required|numeric|min:0.1',
        'alto' => 'required|numeric|min:0.1',
        'peso_bruto_carton' => 'required|numeric|min:0.1'
    ];

    public function create()
    {
        $this->validate([
            'carga' => 'required',
            'proveedor' => 'required',
            'costo_envio' => 'required|numeric|gt:0'
        ]);
        Cotizaciones::where('id', $this->cotizacion_id)->update([
            'usuario_id' => $this->cliente ?? auth()->user()->id,
            'tipo_carga' => $this->carga,
            'cantidad_proveedores' => $this->proveedor,
            'flete' => $this->costo_envio,
            'total_logistica' => $this->costo_envio + 100
        ]);
        return redirect()->to('/cotizacion/aerea/' . $this->cotizacion_id);
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
            Aereo::create([
                'cotizacion_id' => $this->cotizacion_id,
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
                'producto',
                'largo',
                'ancho',
                'alto',
                'peso_bruto_carton'
            ]);
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }

    public function total()
    {

        $this->total = Aereo::where('cotizacion_id', $this->cotizacion_id)->sum('total');
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
            Aereo::destroy($id);
            $this->total();
            $this->emit('alert', 'Registro eliminado!');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
}
