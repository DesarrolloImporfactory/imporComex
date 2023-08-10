<?php

namespace App\Http\Livewire\Area;

use App\Models\Insumo;
use Livewire\Component;

class CreateProducts extends Component
{
    public $nombre_producto, $valor_porcentual;

    public function render()
    {
        return view('livewire.area.create-products');
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public $rules = [
        'nombre_producto' => 'required',
        'valor_porcentual' => 'required|numeric|min:0'
    ];

    public function create()
    {
        $this->validate();
        try {
            Insumo::create([
                'nombre' => $this->nombre_producto,
                'porcentaje' => $this->valor_porcentual,
                'usuario_id' => auth()->user()->id
            ]);
            $this->emit('alert', 'Producto creado!');
            $this->emit('render_update');
        } catch (\Exception $e) {
            $this->emit('alert', $e->getMessage());
        }
    }
}
