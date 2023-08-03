<?php

namespace App\Http\Livewire\Productos;

use App\Models\Calculadora;
use App\Models\Insumo;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductos extends Component
{
    use WithPagination;
    public $archivo;
    protected $paginationTheme = 'bootstrap';
    public $sort = "id", $direction = "asc";
    public $search = '', $paginate = '10', $idProducto, $ancho, $largo, $alto, $calculadora_id,$volumen;
    protected $listeners = ['delete'];
    public $name, $porcentaje, $usuario_id, $adicional, $variable, $resultado, $usuario;

    public function render()
    {
        $productos = Insumo::with('usuario', 'calculos')
            ->where(function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('porcentaje', 'like', '%' . $this->search . '%');
            })
            ->whereHas('usuario', function ($query) {
                // Agregar la restricción para usuarios con rol "Client"
                $query->whereHas("roles", function ($q) {
                    $q->where("name", "Client");
                });
            })
            ->whereNotNull('usuario_id')
            ->paginate($this->paginate);

        $clientes = User::whereHas("roles", function ($q) {
            $q->where("name", "Client");
        })->get();
        return view('livewire.productos.admin-productos', compact('productos', 'clientes'))->extends('adminlte::page')
            ->section('content');
    }
    public $rules = [
        'name' => 'required|string|min:2|max:20',
        'porcentaje' => 'required|numeric',
        'usuario_id' => 'required',
        'adicional' => 'required | numeric| min:0.1',
        'variable' => 'required',
        'ancho' => 'required | numeric| min:0.1',
        'alto' => 'required | numeric| min:0.1',
        'largo' => 'required | numeric| min:0.1',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function order($valor)
    {
        if ($this->sort == $valor) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $valor;
            $this->direction = 'asc';
        }
    }
    public function create()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:20',
            'porcentaje' => 'required|numeric',
            'usuario' => 'required',
            'adicional' => 'required | numeric| min:0.1',
            'variable' => 'required',
            'ancho' => 'required | numeric| min:0.1',
            'alto' => 'required | numeric| min:0.1',
            'largo' => 'required | numeric| min:0.1',
        ]);
        try {
            Insumo::create([
                'nombre' => $this->name,
                'porcentaje' => $this->porcentaje,
                'usuario_id' => $this->usuario,
                'adicional' => $this->adicional,
                'variable' => $this->variable,
                'total' => $this->resultado,
                'largo' => $this->largo,
                'ancho' => $this->ancho,
                'alto' => $this->alto,
                'volumen' => (($this->largo * $this->ancho * $this->alto) / 1000000) * 1,
            ]);
            $this->reset(['name', 'porcentaje']);
            $this->emit('alert', 'Registro creado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function calcular()
    {
        if ($this->variable == 'unidad') {
            $this->resultado = round($this->adicional * 6, 2);
        }
        if ($this->variable == 'porcentual') {
            $this->resultado = round($this->adicional * 0.1, 2);
        }
        if ($this->variable == 'kilogramos') {
            $this->resultado = round($this->adicional * 5.50, 2);
        }
    }
    public function show(Int $id)
    {
        try {
            $producto = Insumo::findOrFail($id);
            $this->name = $producto->nombre;
            $this->porcentaje = $producto->porcentaje;
            $this->adicional = $producto->adicional;
            $this->variable = $producto->variable;
            $this->resultado = $producto->total;
            $this->idProducto = $producto->id;
            $this->largo = $producto->largo;
            $this->ancho = $producto->ancho;
            $this->alto = $producto->alto;
            $this->volumen = $producto->volumen;
            $selects = [
                'usuario' => $producto->usuario_id,
            ];
            $this->emit('selects', $selects);
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function update()
    {
        $this->validate();
        try {
            Insumo::where('id', $this->idProducto)->update([
                'nombre' => $this->name,
                'porcentaje' => $this->porcentaje,
                'usuario_id' => $this->usuario_id,
                'adicional' => $this->adicional,
                'variable' => $this->variable,
                'total' => $this->resultado,
                'largo' => $this->largo,
                'ancho' => $this->ancho,
                'alto' => $this->alto,
                'volumen' => (($this->largo * $this->ancho * $this->alto) / 1000000) * 1,
            ]);
            $this->reset(['name', 'porcentaje']);
            $this->emit('alert', 'Registro update con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function delete(Int $id)
    {
        try {
            Insumo::destroy($id);
            $this->emit('alert', 'Registro eliminado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
}
