<?php

namespace App\Http\Livewire\Productos;

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
    public $search = '', $paginate = '10', $idProducto;
    protected $listeners = ['delete'];
    public $name, $porcentaje, $usuario_id;

    public function render()
    {
        $productos = Insumo::with('usuario')
            ->where(function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('porcentaje', 'like', '%' . $this->search . '%');
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
        'usuario_id' => 'required'
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
        $this->validate();
        try {
            Insumo::create([
                'nombre' => $this->name,
                'porcentaje' => $this->porcentaje,
                'usuario_id' => $this->usuario_id
            ]);
            $this->reset(['name', 'porcentaje']);
            $this->emit('alert', 'Registro creado con exito!.');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
    public function show(Int $id)
    {
        try {
            $producto = Insumo::findOrFail($id);
            $this->name = $producto->nombre;
            $this->porcentaje = $producto->porcentaje;
            // $this->usuario_id = $producto->usuario_id;
            $this->idProducto = $producto->id;
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
                'usuario_id' => $this->usuario_id
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
